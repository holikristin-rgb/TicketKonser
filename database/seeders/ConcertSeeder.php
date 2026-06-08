<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Concert;

class ConcertSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Konser Raisa
        Concert::create([
            'nama_konser' => 'Raisa Live in Concert: With Love',
            'harga' => 750000,
            'stok' => 50,
        ]);

        // 2. Konser Afgan
        Concert::create([
            'nama_konser' => 'Afgan Evolution Tour 2026',
            'harga' => 650000,
            'stok' => 45,
        ]);

        // 3. Konser Tulus
        Concert::create([
            'nama_konser' => 'Tulus Tur Manusia',
            'harga' => 850000,
            'stok' => 60,
        ]);

        // 4. Konser Nadin Amizah
        Concert::create([
            'nama_konser' => 'Nadin Amizah: Konser Selamat Ulang Tahun',
            'harga' => 550000,
            'stok' => 40,
        ]);
    }
}