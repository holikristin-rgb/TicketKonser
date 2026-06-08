<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                // Relasi ke User
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                // Relasi ke Concert
                $table->foreignId('concert_id')->constrained('concerts')->onDelete('cascade');
                
                $table->integer('jumlah_tiket');
                $table->decimal('total_harga', 15, 2);
                $table->string('status')->default('PENDING'); // PENDING, SUCCESS, REJECTED
                $table->string('bukti_pembayaran')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};