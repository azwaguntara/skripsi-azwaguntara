<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smart;
use App\Models\Copras;
use App\Models\KelompokAlternatif;
use Barryvdh\DomPDF\Facade\Pdf;

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


    // DOWNLOAD PDF
    public function downloadPdf(Request $request)
    {
        $kelompokId = $request->kelompok;

        if (!$kelompokId) {
            return redirect()
                ->route('riwayat.index')
                ->with('error', 'Silakan pilih dusun terlebih dahulu.');
        }

        $dataKelompok = KelompokAlternatif::findOrFail($kelompokId);

        $smart = Smart::with('alternatif.kelompok')
            ->whereHas('alternatif', function ($q) use ($kelompokId) {
                $q->where('kelompok_id', $kelompokId);
            })
            ->orderBy('ranking')
            ->get();

        $copras = Copras::with('alternatif.kelompok')
            ->whereHas('alternatif', function ($q) use ($kelompokId) {
                $q->where('kelompok_id', $kelompokId);
            })
            ->orderBy('ranking')
            ->get();

        $pdf = Pdf::loadView(
            'riwayat.pdf',
            compact(
                'smart',
                'copras',
                'dataKelompok'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        $namaFile =
            'Laporan_Ranking_' .
            str_replace(' ', '_', $dataKelompok->dusun) .
            '.pdf';

        return $pdf->download($namaFile);
    }
}
