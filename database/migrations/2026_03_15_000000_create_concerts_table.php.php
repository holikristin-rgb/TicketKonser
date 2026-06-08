<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('concerts')) {
            Schema::create('concerts', function (Blueprint $table) {
                $table->id();
                $table->string('nama_konser');
                $table->text('deskripsi')->nullable();
                $table->decimal('harga', 15, 2);
                $table->date('tanggal_konser')->nullable();
                $table->string('lokasi')->nullable();
                $table->integer('stok_tiket')->default(0);
                $table->string('poster')->nullable();
                $table->string('genre')->default('General');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('concerts');
    }
};