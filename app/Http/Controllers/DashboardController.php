<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Konser (Disesuaikan dengan variabel $concerts di Blade)
        // Kita gunakan format array of objects agar bisa dipanggil dengan $ticket->nama_konser
        $concerts = [
            (object) [
                'id' => 1,
                'nama_konser' => 'Tulus',
                'genre' => 'Pop / Soul',
                'poster' => 'artis/Tulus.jpg',
                'harga' => 500000,
                'stok_tiket' => 50
            ],
            (object) [
                'id' => 2,
                'nama_konser' => 'Raisa Anggiani',
                'genre' => 'Folk Pop',
                'poster' => 'artis/Raisa.jpg',
                'harga' => 350000,
                'stok_tiket' => 25
            ],
            (object) [
                'id' => 3,
                'nama_konser' => 'Nadin Amizah',
                'genre' => 'Indie Folk',
                'poster' => 'artis/Nadin.jpg',
                'harga' => 450000,
                'stok_tiket' => 10
            ],
        ];

        // 2. Data Booking (Wajib ada agar bagian "Tiket Saya" tidak error)
        // Sementara kita buat array kosong jika user belum pernah memesan
        $bookings = [
            // Contoh jika ada data:
            /*
            (object) [
                'concert' => (object) ['nama_konser' => 'Tulus'],
                'jumlah_tiket' => 2,
                'total_harga' => 1000000,
                'status' => 'SUCCESS'
            ]
            */
        ];

        // 3. Mengirimkan variabel ke view dashboard
        // Pastikan nama di compact sesuai dengan yang ada di file Blade Anda
        return view('dashboard', compact('concerts', 'bookings'));
    }
}