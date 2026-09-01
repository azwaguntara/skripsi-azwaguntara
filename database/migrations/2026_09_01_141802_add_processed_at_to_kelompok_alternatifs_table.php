<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelompok_alternatifs', function (Blueprint $table) {
            $table->timestamp('smart_processed_at')
                ->nullable()
                ->after('tanggal');

            $table->timestamp('copras_processed_at')
                ->nullable()
                ->after('smart_processed_at');
        });
    }

    public function down(): void
    {
        Schema::table('kelompok_alternatifs', function (Blueprint $table) {
            $table->dropColumn([
                'smart_processed_at',
                'copras_processed_at',
            ]);
        });
    }
};
