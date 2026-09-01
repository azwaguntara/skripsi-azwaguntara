<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Penilaian;

class KriteriaController extends Controller
{

    public function index()
    {
        $data = Kriteria::all();

        return view('kriteria.index', compact('data'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $r)
    {
        Kriteria::create($r->all());

        return redirect('/kriteria')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Kriteria::findOrFail($id);

        return view('kriteria.edit', compact('data'));
    }

    public function update(Request $r, $id)
    {
        $data = Kriteria::findOrFail($id);

        $data->update($r->all());

        return redirect('/kriteria')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        // Cek apakah kriteria masih digunakan pada data penilaian
        $digunakan = Penilaian::where('kriteria_id', $kriteria->id)->exists();

        if ($digunakan) {
            return redirect('/kriteria')
                ->with(
                    'error',
                    'Data Kriteria tidak dapat dihapus karena masih digunakan pada data penilaian.'
                );
        }

        $kriteria->delete();

        return redirect('/kriteria')
            ->with('success', 'Kriteria berhasil dihapus.');
    }
}
