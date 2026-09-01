<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Copras;
use App\Models\KelompokAlternatif;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $alternatifs = Alternatif::where(
            'kelompok_id',
            $id
        )->get();

        if ($alternatifs->isEmpty()) {

            return redirect()->route('copras.index')
                ->with(
                    'error',
                    'Dusun belum memiliki data alternatif'
                );
        }

        $kriterias = Kriteria::all();

        // ==========================================
        // 1. MATRIKS KEPUTUSAN
        // ==========================================

        /*
        |--------------------------------------------------------------------------
        | OPTIMASI:
        | Ambil seluruh penilaian dalam SATU query.
        |--------------------------------------------------------------------------
        */

        $alternatifIds = $alternatifs->pluck('id');

        $penilaians = Penilaian::whereIn(
            'alternatif_id',
            $alternatifIds
        )
            ->get()
            ->keyBy(function ($item) {

                return $item->alternatif_id
                    . '-' .
                    $item->kriteria_id;
            });

        $matrix = [];
        $alternatifLengkap = [];

        foreach ($alternatifs as $alt) {

            $alternatifLengkap[$alt->id] = true;

            foreach ($kriterias as $k) {

                $key = $alt->id . '-' . $k->id;

                $data = $penilaians->get($key);

                // Simpan nilai kosong sebagai 0
                // untuk kebutuhan tampilan matriks
                $matrix[$alt->id][$k->id] = $data
                    ? $data->nilai
                    : 0;

                // Jika ada minimal satu nilai kosong,
                // alternatif dianggap belum lengkap
                if (
                    !$data ||
                    $data->nilai === null ||
                    $data->nilai === ''
                ) {

                    $alternatifLengkap[$alt->id] = false;
                }
            }
        }

        // ==========================================
        // 2. NORMALISASI
        // ==========================================

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

        // ==========================================
        // 3. MATRIKS TERBOBOT
        // ==========================================

        $terbobot = [];

        foreach ($alternatifs as $alt) {

            foreach ($kriterias as $k) {

                $terbobot[$alt->id][$k->id] =
                    $normal[$alt->id][$k->id] * $k->bobot;
            }
        }

        // ==========================================
        // 4. S+ DAN S-
        // ==========================================

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

        // ==========================================
        // 5. TOTAL S-
        // ==========================================

        $totalSminus = array_sum($sminus);

        // ==========================================
        // 6. SUM INVERSE
        // ==========================================

        $sumInv = 0;

        foreach ($sminus as $val) {
            if ($val != 0) {
                $sumInv += 1 / $val;
            }
        }

        // ==========================================
        // 7. NILAI Qi
        // ==========================================

        $qiData = [];

        foreach ($alternatifs as $alt) {

            if ($sminus[$alt->id] != 0 && $sumInv != 0) {

                $qi = $splus[$alt->id] +
                    (
                        $totalSminus /
                        (
                            $sminus[$alt->id] * $sumInv
                        )
                    );
            } else {

                $qi = $splus[$alt->id];
            }

            $qiData[$alt->id] = $qi;
        }

        // ==========================================
        // 8. NILAI Qi DAN Ui
        // ==========================================

        $qmax = !empty($qiData)
            ? max($qiData)
            : 0;

        $hasil = [];

        foreach ($alternatifs as $alt) {

            $qi = $qiData[$alt->id];

            $ui = $qmax == 0
                ? 0
                : ($qi / $qmax) * 100;

            $hasil[] = [
                'id' => $alt->id,
                'nama' => $alt->nama,
                'qi' => $qi,
                'ui' => $ui
            ];
        }
        // ==========================================
        // 9. URUTKAN RANKING
        // ==========================================

        usort(
            $hasil,
            function ($a, $b) {
                return $b['qi'] <=> $a['qi'];
            }
        );

        // Jika nilai Qi sama, maka ranking juga sama.
        foreach ($hasil as $key => $item) {

            $ranking = 1;

            foreach ($hasil as $pembanding) {

                if ($pembanding['qi'] > $item['qi']) {
                    $ranking++;
                }
            }

            $hasil[$key]['ranking'] = $ranking;
        }

        // ==========================================
        // 10. SIMPAN HASIL COPRAS
        // ==========================================

        $coprasLama = Copras::where(
            'kelompok_id',
            $id
        )
            ->whereIn(
                'alternatif_id',
                $alternatifIds
            )
            ->get()
            ->keyBy('alternatif_id');

        $dataUpdate = [];
        $dataInsert = [];

        foreach ($hasil as $item) {

            $alternatifId = $item['id'];

            if ($coprasLama->has($alternatifId)) {

                $copras = $coprasLama->get($alternatifId);

                $dataUpdate[$copras->id] = [
                    'nilai' => $item['qi'],
                    'ranking' => $item['ranking']
                ];
            } else {

                $dataInsert[] = [
                    'alternatif_id' => $alternatifId,
                    'kelompok_id' => $id,
                    'nilai' => $item['qi'],
                    'ranking' => $item['ranking'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN SECARA EFISIEN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $dataUpdate,
            $dataInsert
        ) {

            // ==========================================
            // UPDATE DATA LAMA SECARA BULK
            // ==========================================

            if (!empty($dataUpdate)) {

                $table = (new Copras)->getTable();

                $ids = array_keys($dataUpdate);

                $caseNilai = 'CASE id ';
                $caseRanking = 'CASE id ';

                $bindings = [];

                foreach ($dataUpdate as $id => $data) {

                    $caseNilai .= 'WHEN ? THEN ? ';
                    $bindings[] = $id;
                    $bindings[] = $data['nilai'];
                }

                $caseNilai .= 'END';

                foreach ($dataUpdate as $id => $data) {

                    $caseRanking .= 'WHEN ? THEN ? ';
                    $bindings[] = $id;
                    $bindings[] = $data['ranking'];
                }

                $caseRanking .= 'END';

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
                    UPDATE {$table}
                    SET
                        nilai = {$caseNilai},
                        ranking = {$caseRanking},
                        updated_at = NOW()
                    WHERE id IN ({$placeholders})
                    ",
                    $bindings
                );
            }

            // ==========================================
            // INSERT DATA BARU SECARA BULK
            // ==========================================

            if (!empty($dataInsert)) {

                Copras::insert($dataInsert);
            }
        });


        // Ambil ID dan status COPRAS
        foreach ($hasil as $key => $item) {

            $copras = Copras::where('alternatif_id', $item['id'])
                ->where('kelompok_id', $id)
                ->first();

            $hasil[$key]['copras_id'] = $copras?->id;
            $hasil[$key]['status'] = $copras?->status ?? 'Direkomendasikan';
        }
        // Cek waktu terakhir perubahan data penilaian ( Untuk update ket di hal index copras status)
        $lastPenilaianUpdate = Penilaian::whereIn(
            'alternatif_id',
            $alternatifIds
        )->max('updated_at');

        $perluUpdateWaktu = false;

        // Belum pernah diproses
        if (is_null($kelompok->copras_processed_at)) {

            $perluUpdateWaktu = true;
        }

        // Sudah pernah diproses dan ada perubahan penilaian
        elseif (
            $lastPenilaianUpdate &&
            Carbon::parse($lastPenilaianUpdate)
            ->gt(Carbon::parse($kelompok->copras_processed_at))
        ) {

            $perluUpdateWaktu = true;
        }

        // Update waktu hanya jika ada perubahan
        if ($perluUpdateWaktu) {

            $kelompok->copras_processed_at = now();
            $kelompok->save();
        }

        // ==========================================
        // 11. TAMPILKAN HASIL
        // ==========================================

        return view(
            'copras.detail',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'matrix',
                'normal',
                'terbobot',
                'splus',
                'sminus',
                'hasil'
            )
        );
    }

    public function tetapkan($id)
    {
        $copras = Copras::findOrFail($id);

        $copras->update([
            'status' => 'Ditetapkan',
        ]);

        return back()->with(
            'success',
            'Alternatif ' . $copras->alternatif->nama .
                ' berhasil ditetapkan sebagai penerima.'
        );
    }

    public function print($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        // Buat token jika belum ada
        if (empty($kelompok->verification_token)) {
            $kelompok->verification_token = Str::uuid();
            $kelompok->save();
        }

        $alternatifs = Alternatif::where(
            'kelompok_id',
            $id
        )->get();

        $kriterias = Kriteria::all();

        // ==========================================
        // MATRIKS
        // ==========================================

        $alternatifIds = $alternatifs->pluck('id');

        $penilaians = Penilaian::whereIn(
            'alternatif_id',
            $alternatifIds
        )
            ->get()
            ->keyBy(function ($item) {
                return $item->alternatif_id
                    . '-'
                    . $item->kriteria_id;
            });

        $matrix = [];

        foreach ($alternatifs as $alt) {

            foreach ($kriterias as $k) {

                $key = $alt->id . '-' . $k->id;

                $data = $penilaians->get($key);

                $matrix[$alt->id][$k->id] = $data
                    ? $data->nilai
                    : 0;
            }
        }

        // ==========================================
        // HASIL COPRAS
        // ==========================================

        $dataCopras = Copras::with('alternatif')
            ->where('kelompok_id', $id)
            ->orderBy('ranking')
            ->get();

        $qmax = $dataCopras->max('nilai');

        $ranking = $dataCopras->map(
            function ($item) use ($qmax) {

                return [
                    'ranking' => $item->ranking,
                    'nama' => $item->alternatif->nama,
                    'qi' => $item->nilai,
                    'ui' => $qmax == 0
                        ? 0
                        : ($item->nilai / $qmax) * 100
                ];
            }
        );

        // ==========================================
        // QR CODE VERIFIKASI
        // ==========================================

        $verificationUrl = route(
            'copras.verify',
            $kelompok->verification_token
        );

        $qrCode = base64_encode(
            QrCode::format('svg')
                ->size(110)
                ->margin(1)
                ->generate($verificationUrl)
        );

        return view(
            'copras.print',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'matrix',
                'ranking',
                'qrCode'
            )
        );
    }

    public function downloadPdf($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        // Buat token jika belum ada
        if (empty($kelompok->verification_token)) {
            $kelompok->verification_token = Str::uuid();
            $kelompok->save();
        }

        $alternatifs = Alternatif::where(
            'kelompok_id',
            $id
        )->get();

        $kriterias = Kriteria::all();

        // ==========================================
        // MATRIKS
        // ==========================================

        $alternatifIds = $alternatifs->pluck('id');

        $penilaians = Penilaian::whereIn(
            'alternatif_id',
            $alternatifIds
        )
            ->get()
            ->keyBy(function ($item) {
                return $item->alternatif_id
                    . '-'
                    . $item->kriteria_id;
            });

        $matrix = [];

        foreach ($alternatifs as $alt) {

            foreach ($kriterias as $k) {

                $key = $alt->id . '-' . $k->id;

                $data = $penilaians->get($key);

                $matrix[$alt->id][$k->id] = $data
                    ? $data->nilai
                    : 0;
            }
        }

        // ==========================================
        // HASIL COPRAS
        // ==========================================

        $dataCopras = Copras::with('alternatif')
            ->where('kelompok_id', $id)
            ->orderBy('ranking')
            ->get();

        $qmax = $dataCopras->max('nilai');

        $ranking = $dataCopras->map(
            function ($item) use ($qmax) {

                return [
                    'ranking' => $item->ranking,
                    'nama' => $item->alternatif->nama,
                    'qi' => $item->nilai,
                    'ui' => $qmax == 0
                        ? 0
                        : ($item->nilai / $qmax) * 100
                ];
            }
        );

        // ==========================================
        // QR CODE VERIFIKASI
        // ==========================================

        $verificationUrl = route(
            'copras.verify',
            $kelompok->verification_token
        );

        $qrCode = base64_encode(
            QrCode::format('svg')
                ->size(110)
                ->margin(1)
                ->generate($verificationUrl)
        );

        // ==========================================
        // GENERATE PDF
        // ==========================================

        $pdf = Pdf::loadView(
            'copras.print',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'matrix',
                'ranking',
                'qrCode'
            ) + [
                'isPdf' => true
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            'Perhitungan-COPRAS-' . $kelompok->dusun . '.pdf'
        );
    }

    public function verify($token)
    {
        $kelompok = KelompokAlternatif::where(
            'verification_token',
            $token
        )->firstOrFail();

        $dataCopras = Copras::with('alternatif')
            ->where(
                'kelompok_id',
                $kelompok->id
            )
            ->orderBy('ranking')
            ->get();

        $qmax = $dataCopras->max('nilai');

        $ranking = $dataCopras->map(
            function ($item) use ($qmax) {

                return [
                    'ranking' => $item->ranking,
                    'nama' => $item->alternatif->nama,
                    'qi' => $item->nilai,
                    'ui' => $qmax == 0
                        ? 0
                        : ($item->nilai / $qmax) * 100
                ];
            }
        );

        return view(
            'copras.verify',
            compact(
                'kelompok',
                'ranking'
            )
        );
    }
}
