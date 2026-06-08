<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $booking->concert->nama_konser }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .ticket-shadow { shadow: none; border: 1px solid #e2e8f0; }
        }
        .ticket-cut {
            position: relative;
        }
        /* Efek lubang potongan tiket */
        .ticket-cut::before, .ticket-cut::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 40px;
            background-color: #f1f5f9; /* Sama dengan bg body */
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }
        .ticket-cut::before { left: -20px; }
        .ticket-cut::after { right: -20px; }
        
        @media print {
            .ticket-cut::before, .ticket-cut::after { background-color: white; }
        }
    </style>
</head>
<body class="bg-slate-100 p-5 md:p-10 flex flex-col items-center">

    <div class="no-print mb-8 flex gap-4">
        <a href="{{ route('dashboard') }}" class="bg-white text-slate-600 px-6 py-3 rounded-2xl font-bold shadow-sm hover:bg-slate-50 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-800 transition flex items-center gap-2">
            <i class="fas fa-download"></i> Cetak / Unduh PDF
        </button>
    </div>

    <div class="w-full max-w-4xl bg-white rounded-[40px] overflow-hidden shadow-2xl ticket-shadow flex flex-col md:flex-row">
        
        <div class="flex-[2] p-10 relative">
            <div class="flex justify-between items-start mb-12">
                <div>
                    <div class="flex items-center gap-2 text-blue-700 mb-1">
                        <div class="bg-blue-700 text-white p-1 rounded italic font-black text-xs">BT</div>
                        <span class="font-black text-xl tracking-tighter italic">BlueTicket</span>
                    </div>
                    <p class="text-slate-400 text-[10px] uppercase font-bold tracking-[0.2em]">Official Admission Ticket</p>
                </div>
                <div class="text-right">
                    <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-xs font-black uppercase border border-green-200">
                        <i class="fas fa-check-circle me-1"></i> Paid / Lunas
                    </span>
                </div>
            </div>

            <div class="mb-10">
                <h1 class="text-4xl font-black text-slate-900 leading-tight uppercase tracking-tight mb-2">
                    {{ $booking->concert->nama_konser }}
                </h1>
                <div class="flex items-center text-blue-700 font-bold">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    <span>{{ $booking->concert->lokasi }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-y-8 gap-x-4 mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nama Penonton</p>
                    <p class="text-lg font-bold text-slate-800">{{ $booking->user->name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu & Tanggal</p>
                    <p class="text-lg font-bold text-slate-800">
                        {{ \Carbon\Carbon::parse($booking->concert->tanggal_konser)->format('d M Y') }}
                    </p>
                    <p class="text-sm font-semibold text-blue-600">Pukul 19:00 WIB - Selesai</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jumlah Tiket</p>
                    <p class="text-lg font-bold text-slate-800">{{ $booking->jumlah_tiket }} Tiket</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Booking ID</p>
                    <p class="text-lg font-mono font-bold text-slate-800">#BT-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <div class="hidden md:flex flex-col items-center justify-between py-6 relative ticket-cut bg-white">
            <div class="w-[2px] h-full bg-slate-100 border-l-2 border-dashed border-slate-200"></div>
        </div>

        <div class="flex-1 bg-slate-50 p-10 flex flex-col items-center justify-center text-center border-t-2 border-dashed border-slate-200 md:border-t-0">
            <div class="bg-white p-4 rounded-3xl shadow-sm mb-6 border border-slate-200">
                <div class="w-32 h-32 bg-slate-900 rounded-xl flex flex-col items-center justify-center p-2 relative overflow-hidden">
                    <i class="fas fa-qrcode text-white text-6xl opacity-20 absolute"></i>
                    <div class="relative z-10 text-white text-[8px] font-bold tracking-[0.2em] leading-tight">
                        VALIDATED BY<br>BLUETICKET
                    </div>
                </div>
            </div>
            
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Scan for Entry</p>
            
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-800">{{ $booking->user->email }}</p>
                <p class="text-[9px] text-slate-400 leading-relaxed italic">
                    Dilarang menggandakan tiket ini. Tunjukkan saat masuk ke gate.
                </p>
            </div>
        </div>
    </div>

    <p class="mt-8 text-slate-400 text-[10px] uppercase font-bold tracking-[0.3em] no-print">
        &copy; {{ date('Y') }} BlueTicket Indonesia - MI POLMED Project
    </p>

</body>
</html>