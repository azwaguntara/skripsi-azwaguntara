<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smart;
use App\Models\Copras;
use App\Models\KelompokAlternatif;
use Barryvdh\DomPDF\Facade\Pdf;

class PenerimaBantuanController extends Controller
{
    /**
     * Ambil data penerima bantuan berdasarkan filter dusun.
     */
    private function getPenerima($kelompokId = null)
    {
        // Ambil data SMART yang sudah ditetapkan
        $smart = Smart::with('alternatif')
            ->where('status', 'Ditetapkan')
            ->when($kelompokId, function ($query) use ($kelompokId) {
                $query->where('kelompok_id', $kelompokId);
            })
            ->get();

        // Ambil data COPRAS yang sudah ditetapkan
        $copras = Copras::with('alternatif')
            ->where('status', 'Ditetapkan')
            ->when($kelompokId, function ($query) use ($kelompokId) {
                $query->where('kelompok_id', $kelompokId);
            })
            ->get();

        $penerima = [];

        // ==========================
        // SMART
        // ==========================
        foreach ($smart as $item) {

            $alternatifId = $item->alternatif_id;

            $penerima[$alternatifId] = [
                'alternatif_id' => $alternatifId,
                'nama' => $item->alternatif->nama,
                'kelompok_id' => $item->kelompok_id,
                'ranking_smart' => $item->ranking,
                'nilai_smart' => $item->nilai,
                'ranking_copras' => null,
                'nilai_copras' => null,
                'metode' => 'SMART',
            ];
        }

        // ==========================
        // COPRAS
        // ==========================
        foreach ($copras as $item) {

            $alternatifId = $item->alternatif_id;

            if (isset($penerima[$alternatifId])) {

                $penerima[$alternatifId]['ranking_copras'] = $item->ranking;
                $penerima[$alternatifId]['nilai_copras'] = $item->nilai;
                $penerima[$alternatifId]['metode'] = 'SMART & COPRAS';
            } else {

                $penerima[$alternatifId] = [
                    'alternatif_id' => $alternatifId,
                    'nama' => $item->alternatif->nama,
                    'kelompok_id' => $item->kelompok_id,
                    'ranking_smart' => null,
                    'nilai_smart' => null,
                    'ranking_copras' => $item->ranking,
                    'nilai_copras' => $item->nilai,
                    'metode' => 'COPRAS',
                ];
            }
        }

        // ==========================
        // NAMA DUSUN
        // ==========================
        $kelompoks = KelompokAlternatif::orderBy('dusun')->get();

        foreach ($penerima as $key => $data) {

            $kelompok = $kelompoks->firstWhere(
                'id',
                $data['kelompok_id']
            );

            $penerima[$key]['dusun'] = $kelompok->dusun ?? '-';
        }

        return $penerima;
    }


    /**
     * Halaman daftar penerima.
     */
    public function index(Request $request)
    {
        $kelompokId = $request->kelompok_id;

        $penerima = $this->getPenerima($kelompokId);

        $kelompoks = KelompokAlternatif::orderBy('dusun')->get();

        return view(
            'penerima.index',
            compact(
                'penerima',
                'kelompoks',
                'kelompokId'
            )
        );
    }


    /**
     * Halaman cetak.
     */
    public function print(Request $request)
    {
        $kelompokId = $request->kelompok_id;

        $penerima = $this->getPenerima($kelompokId);

        $kelompok = $kelompokId
            ? KelompokAlternatif::find($kelompokId)
            : null;

        return view(
            'penerima.print',
            compact(
                'penerima',
                'kelompok'
            )
        );
    }


    /**
     * Download PDF.
     */
    public function downloadPdf(Request $request)
    {
        $kelompokId = $request->kelompok_id;

        $penerima = $this->getPenerima($kelompokId);

        $kelompok = $kelompokId
            ? KelompokAlternatif::find($kelompokId)
            : null;

        $pdf = Pdf::loadView(
            'penerima.print',
            compact(
                'penerima',
                'kelompok'
            )
        )->setPaper('a4', 'landscape');

        $namaFile = 'Daftar-Penerima-Bantuan';

        if ($kelompok) {
            $namaFile .= '-' . $kelompok->dusun;
        }

        $namaFile .= '.pdf';

        return $pdf->download($namaFile);
    }
}
