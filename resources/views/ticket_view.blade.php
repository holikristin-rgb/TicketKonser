<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <title>E-Ticket - {{ $booking->NAMA_KONSER ?? $booking->nama_konser ?? 'Konser Musisi' }}</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="no-print mb-8 flex gap-4">
        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-slate-600 rounded-2xl font-bold text-sm shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
            ← Kembali
        </a>
        <button onclick="downloadGambar()" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all flex items-center gap-2">
            📥 Download Tiket
        </button>
    </div>

    <div id="area-tiket" class="max-w-4xl w-full bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row p-0">
        
        <div class="relative w-full md:w-1/3 h-64 md:h-auto bg-slate-900 flex-shrink-0">
            @php
                $poster = $booking->POSTER ?? $booking->poster ?? '';
                $namaKonser = $booking->NAMA_KONSER ?? $booking->nama_konser ?? 'Event Konser';
            @endphp
            <img src="{{ asset('storage/' . $poster) }}" crossOrigin="anonymous" class="w-full h-full object-cover opacity-60" alt="Poster {{ $namaKonser }}">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent p-8 flex flex-col justify-end">
                <h1 class="text-white text-3xl font-black italic leading-tight mb-2">
                    {{ $namaKonser }}
                </h1>
                <p class="text-blue-400 font-bold text-sm tracking-widest uppercase italic">Official E-Ticket</p>
            </div>
        </div>

        <div class="hidden md:flex flex-col justify-between py-6 relative bg-white flex-shrink-0">
            <div class="w-8 h-8 bg-slate-100 rounded-full -ml-4"></div>
            <div class="border-l-2 border-dashed border-slate-200 h-full my-4"></div>
            <div class="w-8 h-8 bg-slate-100 rounded-full -ml-4"></div>
        </div>

        <div class="flex-1 p-10 flex flex-col justify-between bg-white">
            
            <div class="flex justify-between items-start mb-10">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Status Pembayaran</p>
                    <span class="px-4 py-1.5 bg-green-100 text-green-600 rounded-full text-[10px] font-black uppercase">
                        Confirmed / Paid
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Order ID</p>
                    @php
                        $bookingId = $booking->ID ?? $booking->id ?? 0;
                    @endphp
                    <p class="font-black text-slate-900">#BT-{{ str_pad($bookingId, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-y-8 mb-10">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Nama Pemilik</p>
                    <p class="text-lg font-bold text-slate-800">{{ $booking->USER_NAME ?? $booking->user_name ?? $booking->name ?? 'User BlueTicket' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Jumlah Tiket</p>
                    <p class="text-lg font-bold text-slate-800">{{ $booking->JUMLAH_TIKET ?? $booking->jumlah_tiket ?? 1 }} Ticket(s)</p>
                </div>
                
                <div>
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-1">Jadwal Acara</p>
                    <p class="text-lg font-bold text-slate-800">
                        @php
                            $tanggal = $booking->TANGGAL_KONSER ?? $booking->tanggal_konser ?? now();
                        @endphp
                        {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-1">Lokasi Venue</p>
                    <p class="text-lg font-bold text-slate-800">
                        {{ $booking->LOKASI ?? $booking->lokasi ?? 'Stadion Venue' }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Tipe Tiket</p>
                    <p class="text-lg font-bold text-slate-800">General Admission</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Pintu Masuk</p>
                    <p class="text-lg font-bold text-slate-800 font-mono">GATE 1</p>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-between mt-auto">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Barcode Tiket</p>
                    <div class="flex gap-1 items-end h-10">
                        <div class="w-1 h-full bg-slate-800"></div>
                        <div class="w-0.5 h-full bg-slate-800"></div>
                        <div class="w-2 h-full bg-slate-800"></div>
                        <div class="w-1 h-full bg-slate-800"></div>
                        <div class="w-0.5 h-full bg-slate-800"></div>
                        <div class="w-1.5 h-full bg-slate-800"></div>
                        <div class="w-1 h-full bg-slate-800"></div>
                        <div class="w-0.5 h-full bg-slate-800"></div>
                        <div class="w-2 h-full bg-slate-800"></div>
                        <div class="w-1 h-full bg-slate-800"></div>
                        <div class="w-2 h-full bg-slate-800"></div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-300 uppercase italic">BlueTicket Official Partner</p>
                    <p class="text-[9px] text-slate-400 mt-1 italic">Please bring your ID Card to the venue.</p>
                </div>
            </div>
        </div>
    </div>

    <p class="no-print mt-8 text-slate-400 text-xs font-medium italic">
        © 2026 BlueTicket Project - Mahasiswa Manajemen Informatika Polmed
    </p>

    <script>
        function downloadGambar() {
            const elemenTiket = document.getElementById('area-tiket');
            
            html2canvas(elemenTiket, {
                useCORS: true,
                scale: 2,
                backgroundColor: null
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'BlueTicket-#BT-{{ str_pad($bookingId, 5, "0", STR_PAD_LEFT) }}.png';
                link.href = canvas.toDataURL('image/png');
                
                link.click();
            });
        }
    </script>

</body>
</html>