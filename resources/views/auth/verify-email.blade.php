<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - BlueTicket</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#0B111E] text-slate-100 min-h-screen flex flex-col justify-center items-center px-4 font-sans">

    <div class="mb-8 flex flex-col items-center">
        <div class="w-16 h-16 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(6,182,212,0.3)] mb-4">
            <span class="text-white font-black text-2xl tracking-wider">BT</span>
        </div>
        <h2 class="text-2xl font-bold text-white tracking-tight">BlueTicket</h2>
        <p class="text-xs text-slate-400 uppercase tracking-widest mt-1">Security Verification</p>
    </div>

    <div class="w-full sm:max-w-md bg-[#161F30]/90 border border-slate-800 p-8 rounded-2xl shadow-2xl">
        
        <div class="mb-6 text-sm text-slate-300 leading-relaxed text-center">
            Kami telah mengirimkan kode verifikasi OTP ke alamat email kamu:
            <span class="block mt-2 font-semibold text-cyan-400 bg-cyan-500/10 py-1.5 px-3 rounded-lg border border-cyan-500/20 break-all">
                {{ auth()->user()->email }}
            </span>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-400 text-center bg-green-500/10 py-2 rounded-xl border border-green-500/20">
                Kode OTP baru berhasil dikirim ke email kamu!
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 font-medium text-sm text-rose-400 text-center bg-rose-500/10 py-2 rounded-xl border border-rose-500/20">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}" class="mt-6">
            @csrf
            <div class="flex justify-center gap-3 mb-6">
                <input type="text" name="otp_digits[]" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-[#0B111E] border border-slate-700 rounded-xl text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" required oninput="this.nextElementSibling?.focus()">
                <input type="text" name="otp_digits[]" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-[#0B111E] border border-slate-700 rounded-xl text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" required oninput="this.nextElementSibling?.focus()">
                <input type="text" name="otp_digits[]" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-[#0B111E] border border-slate-700 rounded-xl text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" required oninput="this.nextElementSibling?.focus()">
                <input type="text" name="otp_digits[]" maxlength="1" class="w-12 h-14 text-center text-xl font-bold bg-[#0B111E] border border-slate-700 rounded-xl text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" required>
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/20 transition-all duration-200 transform hover:-translate-y-0.5 cursor-pointer uppercase text-xs tracking-wider text-center">
                Verifikasi Kode OTP
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-800/60 flex items-center justify-between text-xs">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="text-cyan-400 hover:text-cyan-300 font-medium cursor-pointer transition-colors">
                    Tidak menerima kode? Kirim ulang
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-rose-400 underline transition-colors cursor-pointer">
                    Log Out
                </button>
            </form>
        </div>
    </div>

</body>
</html>