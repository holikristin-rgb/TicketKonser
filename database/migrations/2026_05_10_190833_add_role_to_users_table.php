<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom role.
     */
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Cek apakah kolom 'role' sudah ada sebelum ditambahkan
                if (!Schema::hasColumn('users', 'role')) {
                    $table->string('role')->default('user')->after('password');
                }
            });
        }
    }

    /**
     * Batalkan migrasi (Rollback).
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Cek apakah kolom 'role' ada sebelum dihapus
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
            });
        }
    }
};