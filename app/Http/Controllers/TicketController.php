<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id ?? $user->ID;

        $concerts = DB::select("SELECT * FROM CONCERTS ORDER BY ID DESC");

        $bookings = DB::select("
            SELECT 
                b.ID, 
                b.TOTAL_HARGA, 
                b.STATUS, 
                b.JUMLAH_TIKET,
                c.NAMA_KONSER,
                c.ID AS CONCERT_ID
            FROM BOOKINGS b
            LEFT JOIN CONCERTS c ON b.CONCERT_ID = c.ID
            WHERE b.USER_ID = :userId
            ORDER BY b.ID DESC
        ", ['userId' => $userId]);

        return view('user_dashboard', compact('user', 'concerts', 'bookings'));
    }

    public function show($id)
    {
        $concert = DB::table('CONCERTS')->where('ID', $id)->first();
        if (!$concert) {
            abort(404, 'Konser tidak ditemukan');
        }
        return view('concert_detail', compact('concert'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concert_id' => 'required',
            'jumlah_tiket' => 'required|numeric|min:1',
        ]);

        $concert = DB::table('CONCERTS')->where('ID', $request->concert_id)->first();
        
        if (!$concert) {
            return redirect()->back()->with('error', 'Data konser tidak ditemukan.');
        }

        $stok = $concert->STOK_TIKET ?? $concert->stok_tiket ?? $concert->STOK ?? $concert->stok ?? 0;
        $harga = $concert->HARGA ?? $concert->harga ?? 0;

        if ($stok < $request->jumlah_tiket) {
            return redirect()->back()->with('error', "Maaf, stok tiket tidak mencukupi. Sisa stok: {$stok}");
        }

        $totalBayar = $harga * $request->jumlah_tiket;
        $user = Auth::user();

        $bookingId = DB::table('BOOKINGS')->insertGetId([
            'USER_ID' => $user->id ?? $user->ID,
            'CONCERT_ID' => $request->concert_id,
            'JUMLAH_TIKET' => $request->jumlah_tiket,
            'TOTAL_HARGA' => $totalBayar,
            'STATUS' => 'PENDING'
        ]);

        return redirect()->route('payment', ['id' => $bookingId])->with('success', 'Tiket berhasil dipesan, silakan upload bukti pembayaran!');
    }

    public function payment($id)
    {
        $booking = DB::table('BOOKINGS')
            ->join('CONCERTS', 'BOOKINGS.CONCERT_ID', '=', 'CONCERTS.ID')
            ->select('BOOKINGS.*', 'CONCERTS.NAMA_KONSER')
            ->where('BOOKINGS.ID', $id)
            ->first();

        if (!$booking) {
            abort(404, 'Data pemesanan tidak ditemukan.');
        }

        return view('payment', compact('booking'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('bukti_transfer')->store('bukti_pembayaran', 'public');

        DB::table('BOOKINGS')->where('ID', $id)->update([
            'BUKTI_TRANSFER' => $path
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Bukti transfer berhasil diunggah! Menunggu konfirmasi admin.');
    }

    public function downloadTicket($id)
    {
        $booking = DB::table('BOOKINGS')
            ->join('CONCERTS', 'BOOKINGS.CONCERT_ID', '=', 'CONCERTS.ID')
            ->join('USERS', 'BOOKINGS.USER_ID', '=', 'USERS.ID')
            ->select(
                'BOOKINGS.*', 
                'CONCERTS.NAMA_KONSER', 
                'CONCERTS.LOKASI', 
                'CONCERTS.TANGGAL_KONSER', 
                'CONCERTS.POSTER', 
                'USERS.NAME as USER_NAME'
            )
            ->where('BOOKINGS.ID', $id)
            ->first();

        if (!$booking) {
            abort(404, 'Data tiket tidak ditemukan.');
        }

        return view('ticket_view', compact('booking'));
    }

    public function adminDashboard()
    {
        $user = Auth::user();
        $allBookings = DB::select("SELECT b.ID, b.STATUS, b.JUMLAH_TIKET, b.BUKTI_TRANSFER, u.NAME AS USER_NAME, c.NAMA_KONSER FROM BOOKINGS b LEFT JOIN USERS u ON b.USER_ID = u.ID LEFT JOIN CONCERTS c ON b.CONCERT_ID = c.ID ORDER BY b.ID DESC");
        $concerts = DB::select("SELECT * FROM CONCERTS ORDER BY ID DESC");
        return view('admin.dashboard', compact('user', 'allBookings', 'concerts'));
    }

    public function confirmPayment($id)
    {
        $booking = DB::table('BOOKINGS')->where('ID', $id)->first();
        if ($booking) {
            $concertId = $booking->CONCERT_ID ?? $booking->concert_id;
            $jumlahTiket = $booking->JUMLAH_TIKET ?? $booking->jumlah_tiket ?? 0;
            DB::table('CONCERTS')->where('ID', $concertId)->decrement('STOK_TIKET', $jumlahTiket);
            DB::table('BOOKINGS')->where('ID', $id)->update(['STATUS' => 'SUKSES']);
        }
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function rejectPayment($id)
    {
        $booking = DB::table('BOOKINGS')->where('ID', $id)->update(['STATUS' => 'DITOLAK']);
        return redirect()->back()->with('success', 'Pembayaran telah ditolak.');
    }

    public function storeConcert(Request $request)
    {
        $request->validate(['nama_konser' => 'required|string|max:255', 'harga' => 'required|numeric', 'stok_ticket' => 'required|numeric', 'tanggal_konser' => 'required|date', 'lokasi' => 'required|string', 'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $posterPath = $request->file('poster')->store('posters', 'public');
        DB::table('CONCERTS')->insert(['NAMA_KONSER' => $request->nama_konser, 'HARGA' => $request->harga, 'STOK_TIKET' => $request->stok_ticket, 'TANGGAL_KONSER' => $request->tanggal_konser, 'LOKASI' => $request->lokasi, 'GENRE' => $request->genre ?? '-', 'POSTER' => $posterPath]);
        return redirect()->back()->with('success', 'Event konser baru berhasil dipublikasikan!');
    }

    public function updateConcert(Request $request, $id)
    {
        $request->validate(['nama_konser' => 'required|string|max:255', 'harga' => 'required|numeric', 'stok_ticket' => 'required|numeric', 'tanggal_konser' => 'required|date', 'lokasi' => 'required|string']);
        $concert = DB::table('CONCERTS')->where('ID', $id)->first();
        $posterPath = $concert->POSTER ?? $concert->poster ?? null;
        if ($request->hasFile('poster')) {
            if ($posterPath && Storage::disk('public')->exists($posterPath)) { Storage::disk('public')->delete($posterPath); }
            $posterPath = $request->file('poster')->store('posters', 'public');
        }
        DB::table('CONCERTS')->where('ID', $id)->update(['NAMA_KONSER' => $request->nama_konser, 'HARGA' => $request->harga, 'STOK_TIKET' => $request->stok_ticket, 'TANGGAL_KONSER' => $request->tanggal_konser, 'LOKASI' => $request->lokasi, 'GENRE' => $request->genre ?? '-', 'POSTER' => $posterPath]);
        return redirect()->back()->with('success', 'Data konser berhasil diperbarui!');
    }

    public function destroyConcert($id)
    {
        $concert = DB::table('CONCERTS')->where('ID', $id)->first();
        $poster = $concert->POSTER ?? $concert->poster ?? null;
        if ($poster && Storage::disk('public')->exists($poster)) { Storage::disk('public')->delete($poster); }
        DB::table('CONCERTS')->where('ID', $id)->delete();
        return redirect()->back()->with('success', 'Event konser berhasil dihapus!');
    }
}