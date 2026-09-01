<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelompokAlternatif;

class KelompokAlternatifController extends Controller
{
    public function create()
    {
        $dusunList = [
            "Dusun Titi Belanga Sentosa",
            "Dusun Titi Belanga Sejahtera",
            "Dusun Titi Belanga",
            "Dusun Puji Dadi I",
            "Dusun Puji Dadi II",
            "Dusun Puji Dadi III",
            "Dusun Puji Dadi IV",
            "Dusun Sumber Rejo Utara",
            "Dusun Sumber Rejo Selatan",
            "Dusun Jati Mulyo",
            "Dusun Jati Mulyo Makmur",
            "Dusun Sido Mulyo",
            "Dusun Tahun X Utara",
            "Dusun Tahun X Selatan",
            "Dusun Benteng Teladan",
            "Dusun Klonie I",
            "Dusun Tahun XI"
        ];

        return view(
            'alternatif.createkelompok',
            compact('dusunList')
        );
    }

    public function store(Request $r)
    {
        $r->validate([
            'dusun' => 'required',
            'tanggal' => 'required'
        ]);

        KelompokAlternatif::create([
            'dusun' => $r->dusun,
            'tanggal' => $r->tanggal
        ]);

        return redirect('/alternatif');
    }

    public function destroy($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        // Cek apakah dusun masih memiliki alternatif
        if ($kelompok->alternatifs()->exists()) {
            return redirect()
                ->route('alternatif.index')
                ->with(
                    'error',
                    'Dusun tidak dapat dihapus karena masih memiliki data alternatif calon penerima.'
                );
        }

        // Hapus dusun jika sudah tidak memiliki alternatif
        $kelompok->delete();

        return redirect()
            ->route('alternatif.index')
            ->with(
                'success',
                'Data dusun berhasil dihapus.'
            );
    }
}
