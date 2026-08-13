<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\KelompokAlternatif;

class PenilaianController extends Controller
{
    public function index()
    {
        $kelompoks = KelompokAlternatif::latest()->get();

        return view('penilaian.index', compact('kelompoks'));
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

        // Ambil ID alternatif
        $alternatifIds = $alternatifs->pluck('id');

        // Ambil seluruh penilaian sekaligus
        // dan index berdasarkan alternatif + kriteria
        $penilaians = Penilaian::whereIn('alternatif_id', $alternatifIds)
            ->get()
            ->keyBy(function ($item) {
                return $item->alternatif_id . '-' . $item->kriteria_id;
            });

        return view(
            'penilaian.detail',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'penilaians'
            )
        );
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
}
