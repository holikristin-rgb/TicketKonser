<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    protected $table = 'CONCERTS'; // Gunakan huruf kapital untuk Oracle agar lebih aman
    protected $primaryKey = 'id';
    
    /**
     * Nonaktifkan timestamps otomatis karena Oracle sering bermasalah 
     * dengan format default UPDATED_AT milik Laravel (Error ORA-00904).
     */
    public $timestamps = false;

    protected $fillable = [
        'nama_konser',
        'deskripsi',
        'harga',
        'tanggal_konser',
        'lokasi',
        'stok_tiket',
        'poster', // Pastikan poster ada agar gambar artis bisa muncul
    ];

    // Relasi ke Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'concert_id');
    }
}