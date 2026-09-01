<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Smart;
use App\Models\KelompokAlternatif;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $alternatifs = Alternatif::where(
            'kelompok_id',
            $id
        )->get();

        if ($alternatifs->isEmpty()) {

            return redirect()
                ->route('smart.index')
                ->with(
                    'error',
                    'Dusun belum memiliki data alternatif'
                );
        }

        $kriterias = Kriteria::all();

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PENILAIAN SEKALI
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
                    . '-'
                    . $item->kriteria_id;
            });


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

                $key =
                    $alt->id
                    . '-'
                    . $k->id;

                $data = $penilaians->get($key);

                /*
                |--------------------------------------------------------------------------
                | Jika belum ada penilaian:
                | tetap NULL untuk kebutuhan perhitungan.
                |
                | Di Blade boleh ditampilkan sebagai 0.
                |--------------------------------------------------------------------------
                */

                $matrix[$alt->id][$k->id] =
                    $data
                    ? $data->nilai
                    : null;
            }
        }


        // ===============================
        // 3. MIN MAX
        // ===============================

        $minmax = [];

        foreach ($kriterias as $k) {

            $values = [];

            foreach ($alternatifs as $alt) {

                $nilai =
                    $matrix[$alt->id][$k->id];

                /*
                |--------------------------------------------------------------------------
                | Nilai kosong TIDAK dimasukkan
                | ke dalam MIN dan MAX.
                |--------------------------------------------------------------------------
                */

                if (
                    $nilai !== null &&
                    $nilai !== ''
                ) {

                    $values[] = (float) $nilai;
                }
            }

            $minmax[$k->id] = [

                'nama' => $k->nama,

                'min' => count($values)
                    ? min($values)
                    : 0,

                'max' => count($values)
                    ? max($values)
                    : 0
            ];
        }


        // ===============================
        // 4. HITUNG SMART
        // ===============================

        $hasil = [];

        $detail = [];

        foreach ($alternatifs as $alt) {

            $nilaiAkhir = 0;

            /*
            |--------------------------------------------------------------------------
            | Detail sekarang di-index berdasarkan
            | ID alternatif dan ID kriteria.
            |
            | Contoh:
            | $detail[1][1]['utility']
            |--------------------------------------------------------------------------
            */

            $detailAlt = [];

            foreach ($kriterias as $k) {

                $nilai =
                    $matrix[$alt->id][$k->id];

                $min =
                    $minmax[$k->id]['min'];

                $max =
                    $minmax[$k->id]['max'];


                // ===============================
                // PERHITUNGAN UTILITY
                // ===============================

                /*
                |--------------------------------------------------------------------------
                | NILAI KOSONG
                |--------------------------------------------------------------------------
                */

                if (
                    $nilai === null ||
                    $nilai === ''
                ) {

                    /*
                    | Jangan dianggap sebagai 0
                    | dalam perhitungan.
                    */

                    $utilitas = null;
                }


                // ===============================
                // MIN = MAX
                // ===============================

                elseif ($max == $min) {

                    /*
                    |--------------------------------------------------------------------------
                    | Jika semua nilai pada kriteria
                    | sama dan nilainya 0.
                    |--------------------------------------------------------------------------
                    */

                    if ($max == 0) {

                        $utilitas = 0;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Jika semua nilai sama dan nilainya
                    | bukan 0, utility = 1.
                    |
                    | Ini berlaku untuk benefit maupun cost.
                    |--------------------------------------------------------------------------
                    */ else {

                        $utilitas = 1;
                    }
                }


                // ===============================
                // MIN != MAX
                // ===============================

                else {

                    /*
                    |--------------------------------------------------------------------------
                    | BENEFIT
                    |--------------------------------------------------------------------------
                    */

                    if (
                        strtolower($k->tipe)
                        == 'benefit'
                    ) {

                        $utilitas =
                            (
                                $nilai - $min
                            )
                            /
                            (
                                $max - $min
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | COST
                    |--------------------------------------------------------------------------
                    */ else {

                        $utilitas =
                            (
                                $max - $nilai
                            )
                            /
                            (
                                $max - $min
                            );
                    }
                }


                // ===============================
                // NILAI AKHIR KRITERIA
                // ===============================

                $hasilKali =
                    $utilitas !== null
                    ? $k->normalisasi * $utilitas
                    : 0;

                $nilaiAkhir += $hasilKali;


                // ===============================
                // DETAIL
                // ===============================

                /*
                |--------------------------------------------------------------------------
                | Jangan pakai [] lagi.
                | Gunakan ID kriteria sebagai key.
                |--------------------------------------------------------------------------
                */

                $detailAlt[$k->id] = [

                    'kriteria' => $k->nama,

                    'nilai' => $nilai,

                    'utility' => $utilitas,

                    'bobot' => $k->normalisasi,

                    'hasil' => $hasilKali
                ];
            }


            // ===============================
            // HASIL ALTERNATIF
            // ===============================

            $smartData = Smart::where('alternatif_id', $alt->id)
                ->where('kelompok_id', $id)
                ->first();

            $hasil[] = [
                'id' => $alt->id,
                'nama' => $alt->nama,
                'nilai' => $nilaiAkhir,
                'status' => $smartData->status ?? 'Direkomendasikan',
            ];


            // ===============================
            // DETAIL
            // ===============================

            $detail[$alt->id] = $detailAlt;
        }


        // ===============================
        // 5. URUTKAN RANKING
        // ===============================

        usort(
            $hasil,
            function ($a, $b) {
                return $b['nilai'] <=> $a['nilai'];
            }
        );

        // Nilai yang sama mendapatkan ranking yang sama
        foreach ($hasil as $key => $item) {

            $ranking = 1;

            foreach ($hasil as $pembanding) {

                if ($pembanding['nilai'] > $item['nilai']) {
                    $ranking++;
                }
            }

            $hasil[$key]['ranking'] = $ranking;
        }

        // ===============================
        // 6. SIMPAN HASIL SMART
        // ===============================
        $smartLama = Smart::where(
            'kelompok_id',
            $id
        )
            ->whereIn(
                'alternatif_id',
                $alternatifIds
            )
            ->get()
            ->keyBy('alternatif_id');

        foreach ($hasil as $item) {

            $alternatifId = $item['id'];

            // ===============================
            // UPDATE
            // ===============================

            if ($smartLama->has($alternatifId)) {

                $smart = $smartLama->get($alternatifId);

                $smart->nilai = $item['nilai'];
                $smart->ranking = $item['ranking'];

                $smart->save();
            }

            // ===============================
            // CREATE
            // ===============================
            else {

                Smart::create([

                    'alternatif_id' => $alternatifId,

                    'kelompok_id' => $id,

                    'nilai' => $item['nilai'],

                    'ranking' => $item['ranking'],

                ]);
            }
        }

        foreach ($hasil as $key => $item) {

            $smart = Smart::where('alternatif_id', $item['id'])
                ->where('kelompok_id', $id)
                ->first();

            $hasil[$key]['smart_id'] = $smart?->id;
            $hasil[$key]['status'] = $smart?->status ?? 'Direkomendasikan';
        }

        // Cek waktu terakhir perubahan data penilaian
        $lastPenilaianUpdate = Penilaian::whereIn(
            'alternatif_id',
            $alternatifIds
        )->max('updated_at');

        // Tentukan apakah waktu proses perlu diperbarui
        $perluUpdateWaktu = false;

        // Jika belum pernah diproses
        if (is_null($kelompok->smart_processed_at)) {
            $perluUpdateWaktu = true;
        }

        // Jika sudah pernah diproses dan ada perubahan penilaian
        elseif (
            $lastPenilaianUpdate &&
            Carbon::parse($lastPenilaianUpdate)
            ->gt(Carbon::parse($kelompok->smart_processed_at))
        ) {
            $perluUpdateWaktu = true;
        }

        // Simpan waktu hanya jika memang perlu
        if ($perluUpdateWaktu) {

            DB::table('kelompok_alternatifs')
                ->where('id', $id)
                ->update([
                    'smart_processed_at' => now(),
                    'updated_at' => now(),
                ]);
        }
        // ===============================
        // 7. TAMPILKAN HASIL
        // ===============================

        return view(
            'smart.detail',
            compact(
                'kelompok',
                'hasil',
                'kriterias',
                'alternatifs',
                'matrix',
                'minmax',
                'detail'
            )
        );
    }

    public function tetapkan($id)
    {
        $smart = Smart::findOrFail($id);

        $smart->update([
            'status' => 'Ditetapkan',
        ]);

        return back()->with(
            'success',
            'Alternatif ' . $smart->alternatif->nama . ' berhasil ditetapkan sebagai penerima.'
        );
    }


    public function print($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        if (empty($kelompok->verification_token)) {
            $kelompok->verification_token = Str::uuid();
            $kelompok->save();
        }

        $hasil = Smart::with('alternatif')
            ->where('kelompok_id', $id)
            ->orderBy('ranking')
            ->get();

        $alternatifs = Alternatif::with('penilaians')
            ->where('kelompok_id', $id)
            ->get();

        $kriterias = Kriteria::all();

        $verificationUrl = route(
            'smart.verify',
            $kelompok->verification_token
        );

        $qrCode = base64_encode(
            QrCode::format('svg')
                ->size(110)
                ->margin(1)
                ->generate($verificationUrl)
        );

        return view(
            'smart.print',
            compact(
                'kelompok',
                'alternatifs',
                'kriterias',
                'hasil',
                'qrCode'
            )
        );
    }

    public function downloadPdf($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        if (empty($kelompok->verification_token)) {
            $kelompok->verification_token = Str::uuid();
            $kelompok->save();
        }

        $kriterias = Kriteria::orderBy('kode')->get();

        $alternatifs = Alternatif::with('penilaians')
            ->where('kelompok_id', $id)
            ->get();

        $hasil = Smart::with('alternatif')
            ->whereIn(
                'alternatif_id',
                $alternatifs->pluck('id')
            )
            ->orderBy('ranking')
            ->get();

        $verificationUrl = route(
            'smart.verify',
            $kelompok->verification_token
        );

        $qrCode = base64_encode(
            QrCode::format('svg')
                ->size(110)
                ->margin(1)
                ->generate($verificationUrl)
        );

        $pdf = Pdf::loadView(
            'smart.print',
            compact(
                'kelompok',
                'kriterias',
                'alternatifs',
                'hasil',
                'qrCode'
            ) + [
                'isPdf' => true
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            'Perhitungan-SMART-' . $kelompok->dusun . '.pdf'
        );
    }

    public function verify($token)
    {
        $kelompok = KelompokAlternatif::where(
            'verification_token',
            $token
        )->firstOrFail();

        $hasil = Smart::with('alternatif')
            ->where('kelompok_id', $kelompok->id)
            ->orderBy('ranking')
            ->get();

        return view(
            'smart.verify',
            compact(
                'kelompok',
                'hasil'
            )
        );
    }
}
