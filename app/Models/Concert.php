<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    protected $table = 'concerts';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama_konser',
        'deskripsi',
        'harga',
        'tanggal_konser',
        'lokasi',
        'stok_tiket',
        'genre',
        'poster',
    ];

    // Relasi ke Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'concert_id');
    }
}