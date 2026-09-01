<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus relasi kelompok/dusun alternatif
            if (Schema::hasColumn('users', 'kelompok_id')) {
                $table->dropForeign(['kelompok_id']);
                $table->dropColumn('kelompok_id');
            }

            // Tambahkan NIK untuk akun register
            $table->string('nik', 16)
                ->nullable()
                ->unique()
                ->after('name');

            // Tambahkan asal dusun untuk akun register
            // Tidak berhubungan dengan kelompok_alternatifs
            $table->string('dusun', 30)
                ->nullable()
                ->after('nik');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nik']);
            $table->dropColumn(['nik', 'dusun']);
        });
    }
};
