<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BlueTicket') }} - Konser Musik Medan</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'ice-blue': '#F0F9FF',    // Background super soft
                            'sky-light': '#7DD3FC',   // Biru langit cerah aksen
                            'ocean-deep': '#1E3A8A',  // Navy kontras untuk teks/tombol
                            'mint-breeze': '#CCFBF1', // Warna tambahan biar gak monoton
                        }
                    }
                }
            }
        </script>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #F0F9FF; /* Warna Ice Blue */
            }
            
            /* Custom Scrollbar bertema Mint & Sky Blue agar lebih estetik */
            ::-webkit-scrollbar {
                width: 10px;
            }
            ::-webkit-scrollbar-track {
                background: #F0F9FF;
            }
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #7DD3FC, #CCFBF1); /* Gradasi Sky ke Mint */
                border-radius: 20px;
                border: 2px solid #F0F9FF;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #1E3A8A; /* Berubah jadi Navy saat hover */
            }

            /* Efek Glassmorphism halus untuk header */
            .glass-nav {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(125, 211, 252, 0.2);
            }
        </style>
    </head>
    <body class="antialiased text-slate-900 selection:bg-sky-light selection:text-ocean-deep">
        <div class="min-h-screen flex flex-col">
            <div class="sticky top-0 z-50 glass-nav">
                @include('layouts.navigation')
            </div>

            @if (isset($header))
                <header class="bg-white/50 border-b border-sky-100">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-8 bg-sky-light rounded-full"></div>
                            <h2 class="text-2xl font-black text-ocean-deep tracking-tight">
                                {{ $header }}
                            </h2>
                        </div>
                    </div>
                </header>
            @endif

            <main class="flex-grow">
                <div class="py-6">
                    {{ $slot }}
                </div>
            </main>

            <footer class="bg-white border-t border-sky-50 py-12">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <div class="flex justify-center items-center gap-2 mb-4">
                        <div class="h-[1px] w-12 bg-sky-200"></div>
                        <span class="text-ocean-deep font-black tracking-tighter text-xl italic">BlueTicket</span>
                        <div class="h-[1px] w-12 bg-sky-200"></div>
                    </div>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-[0.2em]">
                        &copy; {{ date('Y') }} Project Management Informatics | MI POLMED
                    </p>
                </div>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            const toastConfig = {
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-[2rem] border-none shadow-2xl shadow-sky-100',
                    title: 'text-ocean-deep font-black',
                }
            };

            // Notifikasi Sukses
            @if(session('success'))
                Swal.fire({
                    ...toastConfig,
                    icon: 'success',
                    iconColor: '#7DD3FC',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                });
            @endif

            // Notifikasi Error
            @if(session('error'))
                Swal.fire({
                    ...toastConfig,
                    icon: 'error',
                    iconColor: '#F87171',
                    title: 'Ups!',
                    text: "{{ session('error') }}",
                    showConfirmButton: true,
                    confirmButtonColor: '#1E3A8A',
                    confirmButtonText: 'Oke',
                });
            @endif
        </script>
    </body>
</html>