<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alternatif_id');

            $table->foreignId('kriteria_id');

            $table->double('nilai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};