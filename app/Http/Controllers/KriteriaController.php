<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Imports\KriteriaImport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function importForm()
    {
        return view('kriteria.import');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES IMPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:5120',
            ],
        ], [
            'file.required' => 'File Excel wajib dipilih.',
            'file.mimes' => 'File harus berformat XLSX, XLS, atau CSV.',
            'file.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        try {

            $import = new KriteriaImport();

            Excel::import(
                $import,
                $request->file('file')
            );

            // Jika terdapat kesalahan, batalkan dan tampilkan pesan
            if (!empty($import->errors)) {

                return redirect()
                    ->route('kriteria.index')
                    ->with(
                        'error',
                        implode(' | ', $import->errors)
                    );
            }

            return redirect()
                ->route('kriteria.index')
                ->with(
                    'success',
                    $import->importedCount .
                        ' data kriteria berhasil diimport.'
                );
        } catch (\Throwable $e) {

            return redirect()
                ->route('kriteria.index')
                ->with(
                    'error',
                    'Import gagal: ' . $e->getMessage()
                );
        }
    }
}
