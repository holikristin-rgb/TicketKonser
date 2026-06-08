<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BlueTicket - Indonesian Pop Series</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { 
            background: radial-gradient(circle at 100% 100%, #1e3a8a 0%, #020617 100%); 
        }
        .logo-box {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.2) 0%, rgba(37, 99, 235, 0.4) 100%);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .artist-card { transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1); }
        .artist-card:hover { transform: translateY(-10px); }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900">

    <nav class="bg-white/70 backdrop-blur-2xl sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/" class="flex items-center gap-4 group">
                <div class="logo-box w-11 h-11 rounded-[14px] flex items-center justify-center font-black italic text-blue-500 shadow-lg shadow-blue-500/20">BT</div>
                <div class="flex flex-col">
                    <span class="text-2xl font-extrabold tracking-tighter leading-none">BlueTicket</span>
                    <span class="text-[8px] font-black tracking-[0.4em] text-slate-400 uppercase mt-1">Exclusive Access</span>
                </div>
            </a>

            <div class="flex items-center gap-8">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-600 transition">Log in</a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-blue-600 text-white text-[11px] font-black rounded-full hover:bg-blue-700 transition-all uppercase tracking-widest shadow-xl shadow-blue-200">Daftar Sekarang</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <header class="hero-gradient py-32 text-center text-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 relative z-10">
            <div class="inline-block px-4 py-1.5 mb-8 border border-blue-400/30 rounded-full bg-blue-500/10 backdrop-blur-md">
                <span class="text-[10px] font-bold tracking-[0.2em] text-blue-300 uppercase">⚡ Live in Medan</span>
            </div>
            <h1 class="text-7xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                Rasakan Magis <br><span class="text-blue-400">Musik Indonesia.</span>
            </h1>
            <p class="text-lg text-blue-100/60 max-w-xl mx-auto mb-12 leading-relaxed">
                Dapatkan tiket eksklusif konser artis favoritmu dengan sistem pemesanan tercepat dan teraman di Medan.
            </p>
            <a href="#tiket" class="px-12 py-5 bg-white text-slate-950 rounded-full font-black hover:bg-blue-400 hover:text-white transition-all uppercase text-xs tracking-widest shadow-2xl inline-block">Cari Konser</a>
        </div>
    </header>

    <main id="tiket" class="py-24 max-w-7xl mx-auto px-6">
        
        <div class="flex items-center gap-6 mb-16">
            <h2 class="text-4xl font-black tracking-tighter text-slate-900">Segera Hadir</h2>
            <div class="h-[2px] flex-grow bg-slate-100"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @php
                // DISESUAIKAN: Path gambar sekarang menggunakan folder storage dan ekstensi .jpeg
                $artists = [
                    ['name' => 'Tulus', 'genre' => 'Pop / Soul', 'img' => 'Tulus.jpeg'],
                    ['name' => 'Raisa Anggiani', 'genre' => 'Folk Pop', 'img' => 'Raisa.jpeg'],
                    ['name' => 'Nadin Amizah', 'genre' => 'Indie Folk', 'img' => 'Nadin.jpeg']
                ];
            @endphp

            @foreach($artists as $artist)
            <div class="artist-card relative rounded-[2.5rem] overflow-hidden aspect-[4/5] group cursor-pointer shadow-2xl shadow-slate-200"
                 onclick="window.location.href='{{ auth()->check() ? route('dashboard') : route('register') }}'">
                
                <img src="{{ asset('storage/posters/' . $artist['img']) }}" 
                     alt="{{ $artist['name'] }}"
                     class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-105 group-hover:scale-100">
                
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-90"></div>
                
                <div class="absolute bottom-10 left-10 text-left">
                    <h3 class="text-3xl font-black text-white tracking-tight leading-none">{{ $artist['name'] }}</h3>
                    <p class="text-blue-400 font-bold text-[10px] tracking-[0.2em] uppercase mt-4">{{ $artist['genre'] }}</p>
                </div>

                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <div class="bg-blue-600/90 backdrop-blur-md px-8 py-3 rounded-2xl text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl">
                        Lihat Jadwal
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <footer class="bg-slate-950 py-24 text-center">
        <div class="flex flex-col items-center gap-8">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-black italic text-white text-xs shadow-lg shadow-blue-500/20">BT</div>
                <span class="text-2xl font-black text-white tracking-tighter">BlueTicket</span>
            </div>
            <div class="h-[1px] w-20 bg-slate-800"></div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.5em]">
                &copy; 2026 BlueTicket. All Rights Reserved.
            </p>
        </div>
    </footer>

</body>
</html>