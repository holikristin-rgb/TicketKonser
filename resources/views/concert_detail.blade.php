<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <title>Detail - {{ $concert->nama_konser ?? $concert->NAMA_KONSER }}</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl overflow-hidden p-8">
        
        @php 
            $poster = $concert->POSTER ?? $concert->poster; 
            $namaKonser = $concert->NAMA_KONSER ?? $concert->nama_konser;
            $tanggal = $concert->TANGGAL_KONSER ?? $concert->tanggal_konser;
            $lokasi = $concert->LOKASI ?? $concert->lokasi;
            $idKonser = $concert->ID ?? $concert->id;
        @endphp

        <img src="{{ asset('storage/' . $poster) }}" class="w-full h-64 object-cover rounded-[30px] mb-6 shadow-md">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-black italic text-slate-900 uppercase">Konfirmasi Pesanan</h2>
            <p class="text-slate-500 text-sm mt-1">Kamu akan memesan tiket untuk:</p>
            <p class="font-extrabold text-blue-600 text-lg leading-tight">{{ $namaKonser }}</p>
        </div>

        <div class="bg-slate-50 rounded-3xl p-5 mb-8 flex flex-col gap-4 border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-lg">
                    📅
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Tanggal Konser</p>
                    <p class="text-sm font-bold text-slate-800">
                        {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-lg">
                    📍
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Lokasi Venue</p>
                    <p class="text-sm font-bold text-slate-800">{{ $lokasi }}</p>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs font-semibold">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-2xl text-xs font-semibold">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="concert_id" value="{{ $idKonser }}">
            
            <div class="mb-6">
                <label class="text-[10px] font-black uppercase text-slate-400 ml-2 mb-2 block tracking-widest">Jumlah Tiket</label>
                <div class="relative">
                    <input type="number" name="jumlah_tiket" value="1" min="1" 
                        class="w-full border-2 border-slate-100 rounded-2xl px-5 py-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 outline-none font-bold text-slate-700 transition-all">
                </div>
            </div>

            <button type="submit" class="w-full py-5 bg-blue-600 text-white rounded-[20px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-100 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all">
                Konfirmasi Pesanan
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-[10px] font-black text-slate-300 uppercase italic tracking-widest hover:text-slate-400 transition-colors">
            ← Kembali ke Dashboard
        </a>
    </div>
</body>
</html>