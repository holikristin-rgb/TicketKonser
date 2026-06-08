<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <title>BlueTicket - Dashboard</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-700">
    <nav class="bg-white border-b px-6 py-4 shadow-sm">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-black text-blue-600 italic">BlueTicket.</h1>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    @php 
                        $userName = $user->name ?? 'User'; 
                    @endphp
                    <p class="text-sm font-medium text-slate-600">Halo, <span class="font-bold text-slate-900">{{ $userName }}</span></p>
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md">
                        {{ strtoupper(substr($userName, 0, 1)) }}
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-black text-red-500 uppercase tracking-widest hover:text-red-700 transition cursor-pointer">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">
        {{-- Notifikasi System Alert --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl font-bold text-sm shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold text-sm shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Jumbotron Banner --}}
        <div class="bg-blue-600 rounded-[40px] p-8 md:p-12 mb-12 text-white relative overflow-hidden shadow-xl shadow-blue-500/10">
            <h2 class="text-3xl md:text-4xl font-black italic mb-2">Mau Nonton Konser Apa?</h2>
            <p class="text-blue-100 text-sm opacity-90">Amankan tiket konser musisi favoritmu sebelum kehabisan!</p>
        </div>

        <h3 class="text-sm font-black mb-6 uppercase tracking-widest text-slate-400 italic">Tiket Tersedia</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            @foreach($concerts as $ticket)
                @php
                    $ticketId    = $ticket->id;
                    $namaKonser  = $ticket->nama_konser;
                    $hargaKonser = $ticket->harga;
                    $posterKonser = $ticket->poster;
                    $lokasiKonser = $ticket->lokasi ?? 'Stadion';
                @endphp
                <div class="bg-white rounded-[35px] shadow-sm overflow-hidden border border-slate-100 hover:shadow-md transition duration-300">
                    <img src="{{ asset('storage/' . $posterKonser) }}" class="h-52 w-full object-cover" alt="Poster {{ $namaKonser }}">
                    <div class="p-6">
                        <span class="text-[10px] bg-slate-100 text-slate-500 font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $lokasiKonser }}</span>
                        <h4 class="text-xl font-black italic mt-3 text-slate-900 truncate">{{ $namaKonser }}</h4>
                        <p class="text-blue-600 font-black text-lg mt-1">Rp {{ number_format($hargaKonser, 0, ',', '.') }}</p>
                        
                        <a href="{{ route('concert.show', $ticketId) }}" class="block mt-5 py-3 bg-slate-900 text-white text-center rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-blue-600 transition shadow-lg shadow-slate-900/10 active:scale-95 transform">
                            Detail & Beli Tiket
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- SEKSI 2: RIWAYAT PEMBELIAN TIKET SAYA --}}
        <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black mb-6 uppercase tracking-widest text-slate-400 italic">Tiket Saya</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400 pb-4">
                            <th class="pb-4">Detail Konser</th>
                            <th class="pb-4">Total Bayar</th>
                            <th class="pb-4 text-right">Status & Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($bookings as $booking)
                            @php
                                $bookingId        = $booking->id;
                                $totalHarga       = $booking->total_harga;
                                $statusBooking    = strtoupper($booking->status ?? 'PENDING');
                                $jumlahTiket      = $booking->jumlah_tiket ?? 1;
                                
                                // Baca nama konser dari hasil LEFT JOIN
                                $namaKonserBooking = $booking->nama_konser ?? 'Event Konser (Telah Dihapus Admin)';
                            @endphp
                            <tr>
                                <td class="py-6">
                                    <span class="font-black text-slate-900 text-base block">{{ $namaKonserBooking }}</span>
                                    <div class="flex items-center gap-3 mt-1 text-xs font-semibold text-slate-400">
                                        <span>ID Pesanan: #{{ $bookingId }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-blue-600">{{ $jumlahTiket }} Tiket</span>
                                    </div>
                                </td>
                                <td class="py-6 text-slate-900 font-black text-lg">
                                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                </td>
                                <td class="py-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        {{-- Komponen Badge Status --}}
                                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                            {{ $statusBooking == 'SUCCESS' || $statusBooking == 'SUKSES' ? 'bg-green-100 text-green-600' : 
                                               ($statusBooking == 'REJECTED' || $statusBooking == 'DITOLAK' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600') }}">
                                            {{ $statusBooking == 'SUCCESS' || $statusBooking == 'SUKSES' ? 'SUKSES' : ($statusBooking == 'REJECTED' || $statusBooking == 'DITOLAK' ? 'DITOLAK' : $statusBooking) }}
                                        </span>

                                        {{-- Badge Status --}}
                                        @if($statusBooking == 'SUCCESS' || $statusBooking == 'SUKSES')
                                            <a href="{{ route('ticket.download', $bookingId) }}" class="px-5 py-2.5 bg-slate-900 text-white text-[10px] font-black tracking-widest rounded-xl hover:bg-blue-600 transition-all shadow-md active:scale-95 transform">
                                                LIHAT TIKET
                                            </a>
                                        
                                        {{-- Tombol Selesaikan Pembayaran jika status masih Pending --}}
                                        @elseif($statusBooking == 'PENDING')
                                            <a href="{{ route('payment', $bookingId) }}" class="px-5 py-2.5 bg-blue-600 text-white text-[10px] font-black tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95 transform">
                                                BAYAR SEKARANG
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-slate-400 font-medium italic text-sm">
                                    Belum ada riwayat pemesanan tiket. Jelajahi konser seru di atas!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>