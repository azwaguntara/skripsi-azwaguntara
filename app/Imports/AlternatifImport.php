<?php

namespace App\Imports;

use App\Models\Alternatif;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlternatifImport implements ToModel, WithHeadingRow
{
    protected $kelompokId;

    public function __construct($kelompokId)
    {
        $this->kelompokId = $kelompokId;
    }

    public function model(array $row)
    {
        // Lewati baris kosong
        if (
            empty($row['nama']) &&
            empty($row['nik']) &&
            empty($row['no_hp'])
        ) {
            return null;
        }

        return new Alternatif([
            'nik' => !empty($row['nik'])
                ? trim((string) $row['nik'])
                : null,

            'no_hp' => !empty($row['no_hp'])
                ? trim((string) $row['no_hp'])
                : null,

            'nama' => trim($row['nama'] ?? ''),

            // Dusun diambil dari halaman yang sedang dibuka
            'kelompok_id' => $this->kelompokId,
        ]);
    }
}
