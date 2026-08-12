<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        Kriteria::create([
            'kode' => 'K01',
            'nama' => 'Keluarga miskin kehilangan penghasilan',
            'bobot' => 15,
            'tipe' => 'benefit',
        ]);

        Kriteria::create([
            'kode' => 'K02',
            'nama' => 'Sakit kronis',
            'bobot' => 35,
            'tipe' => 'benefit',
        ]);

        Kriteria::create([
            'kode' => 'K03',
            'nama' => 'Lansia',
            'bobot' => 18,
            'tipe' => 'benefit',
        ]);

        Kriteria::create([
            'kode' => 'K04',
            'nama' => 'Disabilitas',
            'bobot' => 20,
            'tipe' => 'benefit',
        ]);

        Kriteria::create([
            'kode' => 'K05',
            'nama' => 'Jumlah aset',
            'bobot' => 12,
            'tipe' => 'cost',
        ]);
    }
}
