<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\KelompokAlternatif;
use App\Models\Penilaian;
use Illuminate\Validation\Rule;
use App\Imports\AlternatifImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class AlternatifController extends Controller
{
    // HALAMAN INDEX
    public function index()
    {
        $data = KelompokAlternatif::withCount('alternatifs')
            ->latest()
            ->get();

        return view('alternatif.index', compact('data'));
    }

    // HALAMAN DETAIL
    public function detail($id)
    {
        $kelompok = KelompokAlternatif::with('alternatifs')
            ->findOrFail($id);

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
            'nik' => 'required|digits:16|unique:alternatifs,nik',
            'no_hp' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'kelompok_id' => 'required|exists:kelompok_alternatifs,id',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar sebagai calon penerima.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'no_hp.max' => 'No. HP maksimal 20 karakter.',
            'nama.required' => 'Nama warga wajib diisi.',
            'nama.string' => 'Nama warga harus berupa teks.',
            'kelompok_id.required' => 'Dusun wajib dipilih.',
        ]);

        Alternatif::create([
            'nik' => $r->nik,
            'no_hp' => $r->no_hp,
            'nama' => $r->nama,
            'kelompok_id' => $r->kelompok_id,
        ]);

        return redirect()
            ->route('alternatif.detail', $r->kelompok_id)
            ->with('success', 'Alternatif berhasil ditambahkan.');
    }

    // EDIT
    public function edit($id)
    {
        $data = Alternatif::with('kelompok')
            ->findOrFail($id);

        return view('alternatif.edit', compact('data'));
    }

    // UPDATE
    public function update(Request $r, $id)
    {
        $data = Alternatif::findOrFail($id);

        $r->validate([
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('alternatifs', 'nik')->ignore($data->id),
            ],
            'no_hp' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'kelompok_id' => 'required|exists:kelompok_alternatifs,id',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar sebagai calon penerima.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'no_hp.max' => 'No. HP maksimal 20 karakter.',
            'nama.required' => 'Nama warga wajib diisi.',
            'nama.string' => 'Nama warga harus berupa teks.',
            'kelompok_id.required' => 'Dusun wajib dipilih.',
        ]);

        $data->update([
            'nik' => $r->nik,
            'no_hp' => $r->no_hp,
            'nama' => $r->nama,
            'kelompok_id' => $r->kelompok_id,
        ]);

        return redirect()
            ->route('alternatif.detail', $r->kelompok_id)
            ->with('success', 'Alternatif berhasil diperbarui.');
    }

    // HAPUS
    public function destroy(Request $r, $id)
    {
        $data = Alternatif::findOrFail($id);

        // Cek apakah alternatif masih digunakan pada data penilaian
        $digunakan = Penilaian::where(
            'alternatif_id',
            $data->id
        )->exists();

        if ($digunakan) {
            return redirect()
                ->route('alternatif.detail', $data->kelompok_id)
                ->with(
                    'error',
                    'Alternatif tidak dapat dihapus karena masih digunakan pada data penilaian.'
                );
        }

        $kelompok_id = $data->kelompok_id;

        $data->delete();

        return redirect()
            ->route('alternatif.detail', $kelompok_id)
            ->with(
                'success',
                'Alternatif berhasil dihapus.'
            );
    }

    public function importForm($id)
    {
        $kelompok = KelompokAlternatif::findOrFail($id);

        return view('alternatif.import', compact('kelompok'));
    }

    /**
     * Proses import Excel
     */
    public function import(Request $request, $id)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:5120',
            ],
        ]);

        $kelompok = KelompokAlternatif::findOrFail($id);

        try {

            Excel::import(
                new AlternatifImport($kelompok->id),
                $request->file('file')
            );

            return redirect()
                ->route('alternatif.detail', $kelompok->id)
                ->with(
                    'success',
                    'Data alternatif berhasil diimport.'
                );
        } catch (\Throwable $e) {

            return back()
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}
