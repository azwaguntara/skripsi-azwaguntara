<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\KelompokAlternatif;
use App\Imports\PenilaianImport;
use Maatwebsite\Excel\Facades\Excel;


class PenilaianController extends Controller
{
    public function index()
    {
        $kelompoks = KelompokAlternatif::latest()->get();

        $progress = [];

        foreach ($kelompoks as $kelompok) {

            $alternatifIds = Alternatif::where(
                'kelompok_id',
                $kelompok->id
            )->pluck('id');

            $totalData = $alternatifIds->count() * Kriteria::count();

            $totalTerisi = Penilaian::whereIn(
                'alternatif_id',
                $alternatifIds
            )->count();

            if ($totalData == 0 || $totalTerisi == 0) {
                $progress[$kelompok->id] = 'belum';
            } elseif ($totalTerisi < $totalData) {
                $progress[$kelompok->id] = 'proses';
            } else {
                $progress[$kelompok->id] = 'selesai';
            }
        }

        return view(
            'penilaian.index',
            compact('kelompoks', 'progress')
        );
    }

    public function show($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        // Ambil alternatif berdasarkan dusun
        $alternatifs = Alternatif::where('kelompok_id', $id)
            ->orderBy('id')
            ->get();

        // Ambil semua kriteria
        $kriterias = Kriteria::orderBy('id')->get();

        $opsiPenilaian = [
            'Penghasilan' => [
                1 => 'Kurang dari Rp. 300.000',
                2 => 'Rp. 301.000 - Rp. 500.000',
                3 => 'Rp. 501.000 - Rp. 900.000',
                4 => 'Rp. 901.000 - Rp. 1.200.000',
                5 => 'Rp. 1.201.000 - Rp. 1.500.000',
                6 => 'Rp. 1.501.000 - Rp. 1.800.000',
                7 => 'Rp. 1.801.000 - Rp. 2.100.000',
                8 => 'Rp. 2.101.000 - Rp. 2.400.000',
                9 => 'Rp. 2.401.000 - Rp. 2.700.000',
                10 => 'Lebih dari Rp. 2.701.000',
            ],

            'Sakit Kronis' => [
                1 => 'Tidak memiliki penyakit kronis',
                2 => 'Sering sakit tapi bukan kronis',
                3 => 'Sakit kronis ringan',
                4 => 'Sakit kronis dengan keterbatasan aktivitas',
                5 => 'Sakit kronis berat membutuhkan perawatan rutin',
            ],

            'Lansia' => [
                1 => 'Bukan Lansia (Kurang dari 45 tahun)',
                2 => 'Pra-Lansia (Kurang dari 60 tahun)',
                3 => 'Lansia Muda (60 tahun – 69 tahun)',
                4 => 'Lansia Madya (70 tahun – 79 tahun)',
                5 => 'Lansia Tua (80 tahun ke atas)',
            ],

            'Disabilitas' => [
                1 => 'Tidak memiliki disabilitas',
                2 => 'Disabilitas ringan yang tidak terlalu mempengaruhi aktivitas bekerja',
                3 => 'Disabilitas sedang yang mempengaruhi kemampuan bekerja',
                4 => 'Disabilitas berat permanen tetapi masih dapat melakukan aktivitas terbatas',
                5 => 'Disabilitas berat permanen dan tidak produktif',
            ],

            'Jumlah Tanggungan' => [
                1 => 'Tanggungan 1',
                2 => 'Tanggungan 2',
                3 => 'Tanggungan 3',
                4 => 'Tanggungan 4',
                5 => 'Tanggungan 5',
                6 => 'Tanggungan 6',
                7 => 'Tanggungan 7',
                8 => 'Tanggungan 8',
                9 => 'Tanggungan 9',
                10 => 'Tanggungan 10',
            ],

            'Status' => [
                1 => 'Janda/duda dengan penghasilan tanpa tanggungan',
                2 => 'Janda/duda tanpa penghasilan dan tanpa tanggungan',
                3 => 'Menikah dengan penghasilan tetap',
                4 => 'Menikah dengan penghasilan tidak tetap',
                5 => 'Kepala keluarga perempuan',
                6 => 'Janda/duda dengan tanggungan tanpa penghasilan',
            ],

            'Kondisi Rumah' => [
                1 => 'Tidak layak huni',
                2 => 'Sangat sederhana',
                3 => 'Mengontrak',
                4 => 'Sederhana',
                5 => 'Layak huni',
            ],
        ];

        // Ambil ID alternatif
        $alternatifIds = $alternatifs->pluck('id');

        // Ambil seluruh penilaian sekaligus
        // dan index berdasarkan alternatif + kriteria
        $penilaians = Penilaian::whereIn('alternatif_id', $alternatifIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->alternatif_id . '-' . $item->kriteria_id;
            });

        $totalData = $alternatifIds->count() * $kriterias->count();

        $totalTerisi = $penilaians->count();

        $penilaianLengkap = $totalData > 0 && $totalTerisi >= $totalData;

        return view(
            'penilaian.detail',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'penilaians',
                'opsiPenilaian',
                'totalData',
                'totalTerisi',
                'penilaianLengkap'
            )
        );
    }

    public function import(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $kelompok = KelompokAlternatif::findOrFail($id);

        try {

            $import = new PenilaianImport($id);

            Excel::import(
                $import,
                $request->file('file')
            );

            if (!empty($import->errors)) {

                return redirect()
                    ->route('penilaian.show', $id)
                    ->with(
                        'warning',
                        'Import selesai dengan beberapa peringatan: ' .
                            implode(' | ', $import->errors)
                    );
            }

            return redirect()
                ->route('penilaian.show', $id)
                ->with(
                    'success',
                    'Data penilaian berhasil diimport dari Excel.'
                );
        } catch (\Throwable $e) {

            return redirect()
                ->route('penilaian.show', $id)
                ->with(
                    'error',
                    'Import gagal: ' . $e->getMessage()
                );
        }
    }

    public function store(Request $r)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data nilai
        |--------------------------------------------------------------------------
        */

        $nilaiData = $r->input('nilai', []);

        /*
        |--------------------------------------------------------------------------
        | Jika tidak ada data sama sekali
        |--------------------------------------------------------------------------
        */

        if (empty($nilaiData)) {

            return redirect()
                ->route('penilaian.index')
                ->with(
                    'success',
                    'Penilaian berhasil disimpan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Siapkan ID alternatif dan kriteria
        |--------------------------------------------------------------------------
        */

        $alternatifIds = array_keys($nilaiData);

        $kriteriaIds = collect($nilaiData)
            ->flatMap(function ($kriterias) {
                return array_keys($kriterias);
            })
            ->unique()
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Ambil data penilaian lama SEKALI
        |--------------------------------------------------------------------------
        */

        $penilaiansLama = Penilaian::whereIn(
            'alternatif_id',
            $alternatifIds
        )
            ->whereIn(
                'kriteria_id',
                $kriteriaIds
            )
            ->get()
            ->keyBy(function ($item) {

                return $item->alternatif_id
                    . '-'
                    . $item->kriteria_id;
            });

        /*
        |--------------------------------------------------------------------------
        | Persiapkan data UPDATE dan INSERT
        |--------------------------------------------------------------------------
        */

        $dataUpdate = [];
        $dataInsert = [];

        foreach ($nilaiData as $alternatifId => $kriterias) {

            foreach ($kriterias as $kriteriaId => $nilai) {

                /*
                |--------------------------------------------------------------------------
                | Nilai kosong tidak disimpan
                |--------------------------------------------------------------------------
                */

                if ($nilai === null || $nilai === '') {
                    continue;
                }

                $key = $alternatifId . '-' . $kriteriaId;

                /*
                |--------------------------------------------------------------------------
                | DATA SUDAH ADA → UPDATE
                |--------------------------------------------------------------------------
                */

                if ($penilaiansLama->has($key)) {

                    $penilaian = $penilaiansLama->get($key);

                    $dataUpdate[$penilaian->id] = $nilai;
                }

                /*
                |--------------------------------------------------------------------------
                | DATA BELUM ADA → INSERT
                |--------------------------------------------------------------------------
                */ else {

                    $dataInsert[] = [
                        'alternatif_id' => $alternatifId,
                        'kriteria_id'   => $kriteriaId,
                        'nilai'         => $nilai,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $dataUpdate,
            $dataInsert
        ) {

            /*
            |--------------------------------------------------------------------------
            | UPDATE SECARA BULK
            |--------------------------------------------------------------------------
            */

            if (!empty($dataUpdate)) {

                $ids = array_keys($dataUpdate);

                $case = 'CASE id ';
                $bindings = [];

                foreach ($dataUpdate as $id => $nilai) {

                    $case .= 'WHEN ? THEN ? ';

                    $bindings[] = $id;
                    $bindings[] = $nilai;
                }

                $case .= 'END';

                $placeholders = implode(
                    ',',
                    array_fill(
                        0,
                        count($ids),
                        '?'
                    )
                );

                $bindings = array_merge(
                    $bindings,
                    $ids
                );

                DB::update(
                    "
                    UPDATE penilaians
                    SET
                        nilai = {$case},
                        updated_at = NOW()
                    WHERE id IN ({$placeholders})
                    ",
                    $bindings
                );
            }

            /*
            |--------------------------------------------------------------------------
            | INSERT SECARA BULK
            |--------------------------------------------------------------------------
            */

            if (!empty($dataInsert)) {

                Penilaian::insert($dataInsert);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | KEMBALI
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('penilaian.index')
            ->with(
                'success',
                'Penilaian berhasil disimpan.'
            );
    }

    public function importForm($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        $kriterias = Kriteria::orderBy('id')->get();

        return view('penilaian.import', compact(
            'kelompok',
            'kriterias'
        ));
    }
}
