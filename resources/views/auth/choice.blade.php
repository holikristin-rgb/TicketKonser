<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Selangkah Lagi!</h2>
        <p class="text-sm text-gray-600 mt-2">Silakan masuk atau daftar akun baru untuk melanjutkan pemesanan tiket.</p>
    </div>

    <div class="space-y-4">
        <a href="{{ route('login') }}" class="flex w-full justify-center items-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150 shadow-md">
            {{ __('Masuk (Login)') }}
        </a>

        <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-xs uppercase">Atau</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <a href="{{ route('register') }}" class="flex w-full justify-center items-center px-4 py-3 bg-white border-2 border-blue-600 rounded-lg font-bold text-blue-600 uppercase tracking-widest hover:bg-blue-50 transition duration-150">
            {{ __('Daftar Akun Baru') }}
        </a>
    </div>

    <div class="mt-8 text-center">
        <a href="/" class="text-sm text-blue-500 hover:text-blue-700 font-medium">
            &larr; Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>