<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BlueTicket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-[#020617] text-white min-h-screen flex items-center justify-center p-6 relative">
    <div class="absolute top-0 right-0 w-80 h-80 bg-blue-600/10 rounded-full blur-[100px]"></div>

    <div class="w-full max-w-[420px] z-10 text-left">
        <div class="mb-10 text-center">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <span class="text-xl font-black italic text-blue-500">BT</span>
            </div>
            <h1 class="text-3xl font-black tracking-tight italic">Welcome Back.</h1>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-[0.4em] mt-3">Access your exclusive tickets</p>
        </div>

        <div class="glass-card p-10 rounded-[40px]">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-blue-400 mb-2">Email Address</label>
                    <input type="email" name="email" required autofocus class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-sm focus:border-blue-500 focus:ring-0 outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-blue-400 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-sm focus:border-blue-500 focus:ring-0 outline-none">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-black py-5 rounded-2xl hover:bg-blue-500 transition-all shadow-2xl shadow-blue-600/20 uppercase text-[11px] tracking-[0.2em]">
                    Log In
                </button>
            </form>

            <p class="mt-10 text-center text-[10px] font-bold text-slate-600 uppercase tracking-widest">
                New here? <a href="{{ route('register') }}" class="text-blue-500 hover:text-white ml-2">Create Account</a>
            </p>
        </div>
    </div>
</body>
</html>