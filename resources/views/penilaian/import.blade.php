@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            Import Penilaian Excel
        </h4>

        <a href="{{ route('penilaian.show', $kelompok->id) }}"
            class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card p-4">

        <div class="alert alert-info">
            <strong>Dusun:</strong> {{ $kelompok->dusun }}

            <hr>

            <strong>Format Excel yang digunakan:</strong>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Alternatif</th>

                            @foreach($kriterias as $k)
                            <th>{{ $k->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Contoh Nama</td>

                            @foreach($kriterias as $k)
                            <td>1</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <small>
                Masukkan <strong>angka penilaian</strong> sesuai skala
                yang digunakan pada masing-masing kriteria.
            </small>
        </div>

        <form action="{{ route('penilaian.import', $kelompok->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Pilih File Excel
                </label>

                <input type="file"
                    name="file"
                    class="form-control"
                    accept=".xlsx,.xls,.csv"
                    required>
            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('penilaian.show', $kelompok->id) }}"
                    class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit"
                    class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Import Excel
                </button>

            </div>

        </form>

    </div>

</div>

@endsection