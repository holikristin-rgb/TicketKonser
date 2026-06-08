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
        $userId = $user->id;

        $concerts = DB::select("SELECT * FROM concerts ORDER BY id DESC");

        $bookings = DB::select("
            SELECT 
                b.id, 
                b.total_harga, 
                b.status, 
                b.jumlah_tiket,
                c.nama_konser,
                c.id AS concert_id
            FROM bookings b
            LEFT JOIN concerts c ON b.concert_id = c.id
            WHERE b.user_id = :userId
            ORDER BY b.id DESC
        ", ['userId' => $userId]);

        return view('user_dashboard', compact('user', 'concerts', 'bookings'));
    }

    public function show($id)
    {
        $concert = DB::table('concerts')->where('id', $id)->first();
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

        $concert = DB::table('concerts')->where('id', $request->concert_id)->first();
        
        if (!$concert) {
            return redirect()->back()->with('error', 'Data konser tidak ditemukan.');
        }

        $stok = $concert->stok_tiket ?? 0;
        $harga = $concert->harga ?? 0;

        if ($stok < $request->jumlah_tiket) {
            return redirect()->back()->with('error', "Maaf, stok tiket tidak mencukupi. Sisa stok: {$stok}");
        }

        $totalBayar = $harga * $request->jumlah_tiket;
        $user = Auth::user();

        $bookingId = DB::table('bookings')->insertGetId([
            'user_id'      => $user->id,
            'concert_id'   => $request->concert_id,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga'  => $totalBayar,
            'status'       => 'PENDING',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('payment', ['id' => $bookingId])->with('success', 'Tiket berhasil dipesan, silakan upload bukti pembayaran!');
    }

    public function payment($id)
    {
        $booking = DB::table('bookings')
            ->join('concerts', 'bookings.concert_id', '=', 'concerts.id')
            ->select('bookings.*', 'concerts.nama_konser')
            ->where('bookings.id', $id)
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

        DB::table('bookings')->where('id', $id)->update([
            'bukti_transfer' => $path,
            'updated_at'     => now(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Bukti transfer berhasil diunggah! Menunggu konfirmasi admin.');
    }

    public function downloadTicket($id)
    {
        $booking = DB::table('bookings')
            ->join('concerts', 'bookings.concert_id', '=', 'concerts.id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->select(
                'bookings.*', 
                'concerts.nama_konser', 
                'concerts.lokasi', 
                'concerts.tanggal_konser', 
                'concerts.poster', 
                'users.name as user_name'
            )
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) {
            abort(404, 'Data tiket tidak ditemukan.');
        }

        return view('ticket_view', compact('booking'));
    }

    public function adminDashboard()
    {
        $user = Auth::user();
        $allBookings = DB::select("
            SELECT 
                b.id, b.status, b.jumlah_tiket, b.bukti_transfer, 
                u.name AS user_name, 
                c.nama_konser 
            FROM bookings b 
            LEFT JOIN users u ON b.user_id = u.id 
            LEFT JOIN concerts c ON b.concert_id = c.id 
            ORDER BY b.id DESC
        ");
        $concerts = DB::select("SELECT * FROM concerts ORDER BY id DESC");
        return view('admin.dashboard', compact('user', 'allBookings', 'concerts'));
    }

    public function confirmPayment($id)
    {
        $booking = DB::table('bookings')->where('id', $id)->first();
        if ($booking) {
            $concertId   = $booking->concert_id;
            $jumlahTiket = $booking->jumlah_tiket ?? 0;
            DB::table('concerts')->where('id', $concertId)->decrement('stok_tiket', $jumlahTiket);
            DB::table('bookings')->where('id', $id)->update([
                'status'     => 'SUKSES',
                'updated_at' => now(),
            ]);
        }
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function rejectPayment($id)
    {
        DB::table('bookings')->where('id', $id)->update([
            'status'     => 'DITOLAK',
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Pembayaran telah ditolak.');
    }

    public function storeConcert(Request $request)
    {
        $request->validate([
            'nama_konser'    => 'required|string|max:255',
            'harga'          => 'required|numeric',
            'stok_ticket'    => 'required|numeric',
            'tanggal_konser' => 'required|date',
            'lokasi'         => 'required|string',
            'poster'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $posterPath = $request->file('poster')->store('posters', 'public');

        DB::table('concerts')->insert([
            'nama_konser'    => $request->nama_konser,
            'harga'          => $request->harga,
            'stok_tiket'     => $request->stok_ticket,
            'tanggal_konser' => $request->tanggal_konser,
            'lokasi'         => $request->lokasi,
            'genre'          => $request->genre ?? '-',
            'poster'         => $posterPath,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->back()->with('success', 'Event konser baru berhasil dipublikasikan!');
    }

    public function updateConcert(Request $request, $id)
    {
        $request->validate([
            'nama_konser'    => 'required|string|max:255',
            'harga'          => 'required|numeric',
            'stok_ticket'    => 'required|numeric',
            'tanggal_konser' => 'required|date',
            'lokasi'         => 'required|string',
        ]);

        $concert    = DB::table('concerts')->where('id', $id)->first();
        $posterPath = $concert->poster ?? null;

        if ($request->hasFile('poster')) {
            if ($posterPath && Storage::disk('public')->exists($posterPath)) {
                Storage::disk('public')->delete($posterPath);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        DB::table('concerts')->where('id', $id)->update([
            'nama_konser'    => $request->nama_konser,
            'harga'          => $request->harga,
            'stok_tiket'     => $request->stok_ticket,
            'tanggal_konser' => $request->tanggal_konser,
            'lokasi'         => $request->lokasi,
            'genre'          => $request->genre ?? '-',
            'poster'         => $posterPath,
            'updated_at'     => now(),
        ]);

        return redirect()->back()->with('success', 'Data konser berhasil diperbarui!');
    }

    public function destroyConcert($id)
    {
        $concert = DB::table('concerts')->where('id', $id)->first();
        $poster  = $concert->poster ?? null;

        if ($poster && Storage::disk('public')->exists($poster)) {
            Storage::disk('public')->delete($poster);
        }

        DB::table('concerts')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Event konser berhasil dihapus!');
    }
}