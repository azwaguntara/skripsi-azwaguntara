<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\KelompokAlternatif;
use App\Models\Penilaian;

class DashboardController extends Controller
{
    public function index()
    {
        $alternatif = Alternatif::count();
        $kriteria = Kriteria::count();
        $dusun = KelompokAlternatif::count();
        $penilaian = Penilaian::count();

        // Ambil data dusun + jumlah alternatif
        $dataDusun = KelompokAlternatif::withCount('alternatifs')
            ->orderBy('dusun')
            ->get();

        return view('dashboard.index', compact(
            'alternatif',
            'kriteria',
            'dusun',
            'penilaian',
            'dataDusun'
        ));
    }
}
