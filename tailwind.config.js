import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Kamu bisa ganti 'Figtree' ke 'Plus Jakarta Sans' jika ingin lebih modern seperti di gambar
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // PALET WARNA CUSTOM BLUETICKET
                'ice-blue': '#F0F9FF',    // Background halaman (sky-50)
                'sky-light': '#7DD3FC',   // Warna aksen biru langit cerah (sky-300)
                'ocean-deep': '#1E3A8A',  // Navy tua untuk teks judul & tombol utama
                'mint-breeze': '#CCFBF1', // Hijau mint sangat soft untuk variasi (teal-100)
                'soft-indigo': '#E0E7FF', // Ungu muda sangat soft agar tidak monoton satu biru saja
            },
            borderRadius: {
                // Membuat sudut lengkung lebih besar/soft sesuai gambar
                'ticket': '2.5rem',
                'button-custom': '1.25rem',
            },
            boxShadow: {
                // Shadow biru tipis agar terlihat melayang lembut
                'soft-blue': '0 20px 25px -5px rgba(125, 211, 252, 0.1), 0 8px 10px -6px rgba(125, 211, 252, 0.1)',
            }
        },
    },

    plugins: [forms],
};