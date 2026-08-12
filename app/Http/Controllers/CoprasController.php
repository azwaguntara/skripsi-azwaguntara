<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Copras;
use App\Models\KelompokAlternatif;

class CoprasController extends Controller
{
    public function index()
    {
        $kelompoks = KelompokAlternatif::latest()->get();

        return view('copras.index', compact('kelompoks'));
    }

    public function show($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        $alternatifs = Alternatif::where('kelompok_id', $id)->get();

        if ($alternatifs->isEmpty()) {

            return redirect()->route('copras.index')
                ->with('error', 'Dusun belum memiliki data alternatif');

        }

        $kriterias = Kriteria::all();

        $matrix = [];

        // 1. Matriks Keputusan
        foreach ($alternatifs as $alt) {

            foreach ($kriterias as $k) {

                $nilai = Penilaian::where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $k->id)
                    ->value('nilai') ?? 0;

                $matrix[$alt->id][$k->id] = $nilai;
            }
        }

        // 2. Normalisasi
        $normal = [];

        foreach ($kriterias as $k) {

            $total = 0;

            foreach ($alternatifs as $alt) {
                $total += $matrix[$alt->id][$k->id];
            }

            foreach ($alternatifs as $alt) {

                $normal[$alt->id][$k->id] = $total == 0
                    ? 0
                    : $matrix[$alt->id][$k->id] / $total;

            }
        }

        // 3. Terbobot
        $terbobot = [];

        foreach ($alternatifs as $alt) {

            foreach ($kriterias as $k) {

                $terbobot[$alt->id][$k->id] =
                    $normal[$alt->id][$k->id] * $k->bobot;

            }
        }

        // 4. S+ dan S-
        $splus = [];
        $sminus = [];

        foreach ($alternatifs as $alt) {

            $splus[$alt->id] = 0;
            $sminus[$alt->id] = 0;

            foreach ($kriterias as $k) {

                if ($k->tipe == 'benefit') {

                    $splus[$alt->id] +=
                        $terbobot[$alt->id][$k->id];

                } else {

                    $sminus[$alt->id] +=
                        $terbobot[$alt->id][$k->id];

                }

            }
        }

        // 5. Total S-
        $totalSminus = array_sum($sminus);

        // 6. Sum inverse
        $sumInv = 0;

        foreach ($sminus as $val) {
            $sumInv += 1 / ($val + 0.00001);
        }

        // 7. Qi
        $qiData = [];

        foreach ($alternatifs as $alt) {

            $qi = $splus[$alt->id] +
                ($totalSminus /
                    (($sminus[$alt->id] + 0.00001) * $sumInv));

            $qiData[$alt->id] = $qi;
        }

        $qmax = !empty($qiData) ? max($qiData) : 0;

        // 8. Hasil
        $hasil = [];

        foreach ($alternatifs as $alt) {

            $qi = $qiData[$alt->id];




            $ui = $qmax == 0
                ? 0
                : ($qi / $qmax) * 100;

            $hasil[] = [
                'nama' => $alt->nama,
                'qi' => $qi,
                'ui' => $ui
            ];
        }

        usort($hasil, function ($a, $b) {
            return $b['qi'] <=> $a['qi'];
        });


        $periode = date('F Y', strtotime($kelompok->tanggal));

        Copras::where('kelompok_id', $id)
            ->where('periode', $periode)
            ->delete();

        foreach ($hasil as $index => $item) {

            $alternatif = Alternatif::where('nama', $item['nama'])
                ->where('kelompok_id', $id)
                ->first();

            if ($alternatif) {

                Copras::create([
                    'alternatif_id' => $alternatif->id,
                    'kelompok_id' => $id,
                    'nilai' => $item['qi'],
                    'ranking' => $index + 1,

                    'periode' => $periode
                ]);

            }
        }

        return view('copras.detail', compact(
            'kelompok',
            'alternatifs',
            'kriterias',
            'matrix',
            'normal',
            'terbobot',
            'splus',
            'sminus',
            'hasil'
        ));
    }

    public function print($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        $alternatifs = Alternatif::where(
            'kelompok_id',
            $id
        )->get();

        $kriterias = Kriteria::all();

        // MATRIX
        $matrix = [];

        foreach ($alternatifs as $alt) {

            foreach ($kriterias as $k) {

                $matrix[$alt->id][$k->id] =
                    Penilaian::where(
                        'alternatif_id',
                        $alt->id
                    )
                        ->where(
                            'kriteria_id',
                            $k->id
                        )
                        ->value('nilai') ?? 0;
            }
        }

        $dataCopras = Copras::where(
            'kelompok_id',
            $id
        )
            ->orderBy('ranking')
            ->get();

        $qmax = $dataCopras->max('nilai');

        $ranking = $dataCopras->map(function ($item) use ($qmax) {

            return [

                'nama' => $item->alternatif->nama,
                'qi' => $item->nilai,
                'ui' => ($item->nilai / $qmax) * 100

            ];

        });

        return view(
            'copras.print',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'matrix',
                'ranking'
            )
        );
    }

}