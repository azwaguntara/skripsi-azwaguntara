<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smart;
use App\Models\Copras;
use App\Models\KelompokAlternatif;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $kelompok = $request->kelompok;

        // Daftar dusun
        $listKelompok = KelompokAlternatif::all();

        // SMART
        $smart = collect();

        if ($kelompok) {
            $smart = Smart::with(['alternatif.kelompok'])
                ->whereHas('alternatif', function ($q) use ($kelompok) {
                    $q->where('kelompok_id', $kelompok);
                })
                ->orderBy('ranking')
                ->get();
        }

        // COPRAS
        $copras = collect();

        if ($kelompok) {
            $copras = Copras::with(['alternatif.kelompok'])
                ->whereHas('alternatif', function ($q) use ($kelompok) {
                    $q->where('kelompok_id', $kelompok);
                })
                ->orderBy('ranking')
                ->get();
        }

        return view('riwayat.index', compact(
            'smart',
            'copras',
            'listKelompok',
            'kelompok'
        ));
    }
}
