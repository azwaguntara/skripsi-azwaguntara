<?php

namespace App\Imports;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenilaianImport implements ToCollection, WithHeadingRow
{
    protected $kelompokId;

    public $errors = [];

    public function __construct($kelompokId)
    {
        $this->kelompokId = $kelompokId;
    }

    public function collection(Collection $rows)
    {
        $kriterias = Kriteria::orderBy('id')->get();

        foreach ($rows as $index => $row) {

            $baris = $index + 2;

            $nama = trim(
                (string) ($row['nama_alternatif'] ?? '')
            );

            // Lewati baris kosong
            if ($nama === '') {
                continue;
            }

            // Cari alternatif berdasarkan nama + kelompok/dusun
            $alternatif = Alternatif::where('kelompok_id', $this->kelompokId)
                ->whereRaw('LOWER(nama) = ?', [strtolower($nama)])
                ->first();

            if (!$alternatif) {
                $this->errors[] =
                    "Baris {$baris}: {$nama} tidak ditemukan pada dusun ini.";
                continue;
            }

            foreach ($kriterias as $kriteria) {

                // Nama kriteria dijadikan nama kolom Excel
                $header = Str::slug($kriteria->nama, '_');

                $nilai = $row[$header] ?? null;

                // Kalau kosong, jangan mengubah nilai yang sudah ada
                if ($nilai === null || $nilai === '') {
                    continue;
                }

                // Pastikan angka
                if (!is_numeric($nilai)) {
                    $this->errors[] =
                        "Baris {$baris}: nilai {$kriteria->nama} untuk {$nama} harus berupa angka.";
                    continue;
                }

                $nilai = (int) $nilai;

                // Batas nilai sesuai sistem kamu
                $maksimal = match ($kriteria->nama) {
                    'Penghasilan' => 10,
                    'Sakit Kronis' => 5,
                    'Lansia' => 5,
                    'Disabilitas' => 5,
                    'Jumlah Tanggungan' => 10,
                    'Status' => 6,
                    'Kondisi Rumah' => 5,
                    default => 10,
                };

                if ($nilai < 1 || $nilai > $maksimal) {
                    $this->errors[] =
                        "Baris {$baris}: nilai {$kriteria->nama} untuk {$nama} harus antara 1–{$maksimal}.";
                    continue;
                }

                // Simpan / update penilaian
                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $alternatif->id,
                        'kriteria_id' => $kriteria->id,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }
        }
    }
}
