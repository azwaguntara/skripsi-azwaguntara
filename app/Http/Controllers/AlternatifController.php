<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\KelompokAlternatif;

class AlternatifController extends Controller
{

    // HALAMAN INDEX
    public function index()
    {
        $data = KelompokAlternatif::latest()->get();

        return view('alternatif.index', compact('data'));
    }

    // HALAMAN DETAIL
    public function detail($id)
    {
        $kelompok = KelompokAlternatif::with('alternatifs')->findOrFail($id);

        return view('alternatif.detail', compact('kelompok'));
    }

    // FORM TAMBAH
    public function create($kelompok_id)
    {
        $kelompok = KelompokAlternatif::findOrFail($kelompok_id);

        return view(
            'alternatif.create',
            compact('kelompok')
        );
    }

    // SIMPAN
    public function store(Request $r)
    {
        $r->validate([
            'nama' => 'required',
            'kelompok_id' => 'required'
        ]);

        Alternatif::create([
            'nama' => $r->nama,
            'kelompok_id' => $r->kelompok_id
        ]);

        return redirect()->route(
            'alternatif.detail',
            $r->kelompok_id
        );
    }

    // EDIt
    public function edit($id)
    {
        $data = Alternatif::with('kelompok')
            ->findOrFail($id);

        return view('alternatif.edit', compact('data'));
    }



    // UPDATE
    public function update(Request $r, $id)
    {
        $r->validate([
            'nama' => 'required',
            'kelompok_id' => 'required'
        ]);

        $data = Alternatif::findOrFail($id);

        $data->update([
            'nama' => $r->nama,
            'kelompok_id' => $r->kelompok_id
        ]);

        return redirect()->route(
            'alternatif.detail',
            $r->kelompok_id
        );
    }

    // HAPUS

    public function destroy(Request $r, $id)
    {
        $data = Alternatif::findOrFail($id);

        $data->delete();

        return redirect()->route(
            'alternatif.detail',
            $r->kelompok_id
        );
    }
}
