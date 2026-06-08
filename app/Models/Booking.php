<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'concert_id',
        'jumlah_tiket',
        'total_harga',
        'status',
        'bukti_transfer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function concert()
    {
        return $this->belongsTo(Concert::class, 'concert_id', 'id');
    }
}