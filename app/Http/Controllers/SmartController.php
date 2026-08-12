<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Smart;
use App\Models\KelompokAlternatif;

class SmartController extends Controller
{
    public function index()
    {
        $kelompoks = KelompokAlternatif::latest()->get();

        return view('smart.index', compact('kelompoks'));
    }

    public function show($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        $alternatifs = Alternatif::where('kelompok_id', $id)->get();

        if ($alternatifs->isEmpty()) {

            return redirect()->route('smart.index')
                ->with('error', 'Dusun belum memiliki data alternatif');

        }

        $kriterias = Kriteria::all();

        $penilaians = Penilaian::whereHas('alternatif', function ($q) use ($id) {
            $q->where('kelompok_id', $id);
        })->get();

        // ===============================
        // 1. NORMALISASI BOBOT
        // ===============================
        $totalBobot = $kriterias->sum('bobot');

        foreach ($kriterias as $k) {
            $k->normalisasi = $totalBobot != 0
                ? $k->bobot / $totalBobot
                : 0;
        }

        // ===============================
        // 2. MATRIX
        // ===============================
        $matrix = [];

        foreach ($alternatifs as $alt) {

            foreach ($kriterias as $k) {

                $data = $penilaians
                    ->where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $k->id)
                    ->first();

                $matrix[$alt->id][$k->id] = $data
                    ? $data->nilai
                    : 0;
            }
        }

        // ===============================
        // 3. MIN MAX
        // ===============================
        $minmax = [];

        foreach ($kriterias as $k) {

            $values = [];

            foreach ($alternatifs as $alt) {

                if (isset($matrix[$alt->id][$k->id])) {
                    $values[] = $matrix[$alt->id][$k->id];
                }

            }

            $minmax[$k->id] = [
                'nama' => $k->nama,
                'min' => count($values) ? min($values) : 0,
                'max' => count($values) ? max($values) : 0
            ];
        }

        $hasil = [];
        $detail = [];

        // ===============================
        // 4. HITUNG SMART
        // ===============================
        foreach ($alternatifs as $alt) {

            $nilaiAkhir = 0;
            $detailAlt = [];

            foreach ($kriterias as $k) {

                $nilai = $matrix[$alt->id][$k->id];
                $min = $minmax[$k->id]['min'];
                $max = $minmax[$k->id]['max'];

                if ($max == $min) {

                    if ($max == 0) {
                        $utilitas = 0;
                    } else {
                        $utilitas = 1;
                    }

                } else {

                    if ($k->tipe == 'benefit') {
                        $utilitas = ($nilai - $min) / ($max - $min);
                    } else {
                        $utilitas = ($max - $nilai) / ($max - $min);
                    }

                }

                $hasilKali = $k->normalisasi * $utilitas;

                $nilaiAkhir += $hasilKali;

                $detailAlt[] = [
                    'kriteria' => $k->nama,
                    'nilai' => $nilai,
                    'utility' => $utilitas,
                    'bobot' => $k->normalisasi,
                    'hasil' => $hasilKali
                ];
            }

            $hasil[] = [
                'nama' => $alt->nama,
                'nilai' => $nilaiAkhir
            ];

            $detail[$alt->nama] = $detailAlt;
        }

        usort($hasil, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });



        $periode = date('F Y', strtotime($kelompok->tanggal));

        Smart::where('kelompok_id', $id)
            ->where('periode', $periode)
            ->delete();

        foreach ($hasil as $index => $item) {

            $alternatif = Alternatif::where('nama', $item['nama'])
                ->where('kelompok_id', $id)
                ->first();

            if ($alternatif) {

                Smart::create([
                    'alternatif_id' => $alternatif->id,
                    'kelompok_id' => $id,
                    'nilai' => $item['nilai'],
                    'ranking' => $index + 1,
                    'periode' => $periode

                ]);

            }
        }

        return view('smart.detail', compact(
            'kelompok',
            'hasil',
            'kriterias',
            'alternatifs',
            'matrix',
            'minmax',
            'detail'
        ));
    }

    public function print($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);
        $hasil = Smart::with('alternatif')
            ->where('kelompok_id', $id)
            ->orderBy('ranking')
            ->get();

        $alternatifs = Alternatif::where(
            'kelompok_id',
            $id
        )->get();

        $kriterias = Kriteria::all();

        return view(
            'smart.print',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'hasil'
            )
        );
    }

}