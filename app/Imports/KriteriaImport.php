<?php

namespace App\Imports;

use App\Models\Kriteria;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KriteriaImport implements ToCollection, WithHeadingRow
{
    public $errors = [];
    public $importedCount = 0;

    public function collection(Collection $rows)
    {
        $data = [];
        $kodeDalamFile = [];
        $totalBobotImport = 0;

        foreach ($rows as $index => $row) {

            $baris = $index + 2;

            // Lewati baris kosong
            if (collect($row)->filter(function ($value) {
                return $value !== null && trim((string) $value) !== '';
            })->isEmpty()) {
                continue;
            }

            $kode = strtoupper(trim((string) ($row['kode'] ?? '')));
            $nama = trim((string) ($row['nama'] ?? ''));
            $bobot = $row['bobot'] ?? null;
            $tipe = ucfirst(strtolower(trim((string) ($row['tipe'] ?? ''))));

            // Validasi kode
            if ($kode === '') {
                $this->errors[] = "Baris {$baris}: Kode kriteria wajib diisi.";
                continue;
            }

            // Validasi nama
            if ($nama === '') {
                $this->errors[] = "Baris {$baris}: Nama kriteria wajib diisi.";
                continue;
            }

            // Validasi bobot
            if (!is_numeric($bobot) || $bobot <= 0 || $bobot > 1) {
                $this->errors[] = "Baris {$baris}: Bobot harus berupa angka lebih dari 0 dan maksimal 1.";
                continue;
            }

            // Validasi tipe
            if (!in_array($tipe, ['Benefit', 'Cost'])) {
                $this->errors[] = "Baris {$baris}: Tipe harus Benefit atau Cost.";
                continue;
            }

            // Cek duplikat dalam file Excel
            if (in_array($kode, $kodeDalamFile)) {
                $this->errors[] = "Baris {$baris}: Kode {$kode} duplikat dalam file Excel.";
                continue;
            }

            $kodeDalamFile[] = $kode;

            $bobot = (float) $bobot;
            $totalBobotImport += $bobot;

            $data[] = [
                'kode' => $kode,
                'nama' => $nama,
                'bobot' => $bobot,
                'tipe' => $tipe,
            ];
        }

        // Jika tidak ada data
        if (empty($data) && empty($this->errors)) {
            $this->errors[] = 'File Excel tidak memiliki data kriteria.';
            return;
        }

        // Jika ada kesalahan, batalkan seluruh import
        if (!empty($this->errors)) {
            return;
        }

        // Cek kode yang sudah ada di database
        $kodeSudahAda = Kriteria::whereIn('kode', $kodeDalamFile)
            ->pluck('kode')
            ->map(fn($kode) => strtoupper(trim($kode)))
            ->toArray();

        if (!empty($kodeSudahAda)) {
            $this->errors[] = 'Import dibatalkan. Kode kriteria berikut sudah terdaftar: '
                . implode(', ', $kodeSudahAda);
            return;
        }

        // Pastikan total bobot database + import tetap 1.00
        $totalBobotLama = (float) Kriteria::sum('bobot');

        $totalBobotAkhir = $totalBobotLama + $totalBobotImport;

        if (abs($totalBobotAkhir - 1.0) > 0.0001) {
            $this->errors[] = 'Import dibatalkan. Total bobot seluruh kriteria harus tepat 1.00. '
                . 'Total saat ini setelah import: '
                . number_format($totalBobotAkhir, 4, '.', '');
            return;
        }

        // Simpan seluruh data sekaligus
        DB::transaction(function () use ($data) {

            foreach ($data as $item) {
                Kriteria::create($item);
            }

            $this->importedCount = count($data);
        });
    }
}
