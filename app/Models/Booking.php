<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'BOOKINGS';
    protected $primaryKey = 'ID';
    public $incrementing = true; 

    protected $fillable = [
        'USER_ID',
        'CONCERT_ID',
        'JUMLAH_TIKET',
        'TOTAL_HARGA',
        'STATUS',
        'BUKTI_TRANSFER'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'ID');
    }

    public function concert()
    {
        return $this->belongsTo(Concert::class, 'CONCERT_ID', 'ID');
    }
}