<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $alternatifs = Alternatif::where('kelompok_id', $id)->get();

        $kriterias = Kriteria::all();

        $penilaians = Penilaian::with(['alternatif', 'kriteria'])
            ->whereHas('alternatif', function ($q) use ($id) {
                $q->where('kelompok_id', $id);
            })
            ->get();

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

        foreach ($r->nilai as $alt => $krit) {

            foreach ($krit as $k => $nilai) {

                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $alt,
                        'kriteria_id' => $k
                    ],
                    [
                        'nilai' => $nilai
                    ]
                );

            }

        }

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan');

    }

}