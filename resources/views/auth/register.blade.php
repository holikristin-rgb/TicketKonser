<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join BlueTicket - Exclusive Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #0d1b2a, #010409) !important;
        }
    </style>
</head>
<body class="bg-[#010409] min-h-screen flex flex-col items-center justify-center p-4">

    <div class="mb-4">
        <div class="w-16 h-16 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20 transform rotate-12">
            <span class="text-white text-2xl font-black italic tracking-tighter -rotate-12">BT</span>
        </div>
    </div>

    <h1 class="text-white text-3xl font-extrabold tracking-tight mb-1 text-center">Create Account</h1>
    <p class="text-slate-400 text-xs tracking-widest uppercase font-semibold mb-8 text-center">Start Your Musical Journey Today</p>

    <div class="w-full max-w-md bg-slate-900/60 backdrop-blur-xl border border-slate-800 p-8 rounded-[32px] shadow-2xl">
        
        @if ($errors->any())
            <div class="mb-5 p-4 text-xs text-red-400 bg-red-950/40 border border-red-500/50 rounded-2xl">
                <div class="font-bold mb-1">⚠️ Pendaftaran Gagal:</div>
                <ul class="list-disc pl-4 space-y-1 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-[10px] font-black text-blue-400 tracking-[0.15em] uppercase mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name" required
                    class="w-full bg-slate-950/80 border border-slate-800 text-white rounded-2xl px-5 py-3.5 text-sm font-medium focus:outline-none focus:border-blue-500 transition-all placeholder:text-slate-600">
            </div>

            <div>
                <label class="block text-[10px] font-black text-blue-400 tracking-[0.15em] uppercase mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@email.com" required
                    class="w-full bg-slate-950/80 border border-slate-800 text-white rounded-2xl px-5 py-3.5 text-sm font-medium focus:outline-none focus:border-blue-500 transition-all placeholder:text-slate-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-blue-400 tracking-[0.15em] uppercase mb-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required
                        class="w-full bg-slate-950/80 border border-slate-800 text-white rounded-2xl px-5 py-3.5 text-sm font-medium focus:outline-none focus:border-blue-500 transition-all placeholder:text-slate-600">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-blue-400 tracking-[0.15em] uppercase mb-2">Confirm</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required
                        class="w-full bg-slate-950/80 border border-slate-800 text-white rounded-2xl px-5 py-3.5 text-sm font-medium focus:outline-none focus:border-blue-500 transition-all placeholder:text-slate-600">
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-white text-slate-950 font-black text-xs uppercase tracking-[0.15em] py-4 rounded-2xl shadow-lg hover:bg-slate-100 transition-all mt-2">
                Sign Up Now
            </button>
        </form>
    </div>

    <p class="text-slate-500 text-xs font-semibold mt-6 tracking-wide">
        ALREADY HAVE AN ACCOUNT? 
        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition-all ml-1 hover:underline">LOG IN</a>
    </p>

</body>
</html>