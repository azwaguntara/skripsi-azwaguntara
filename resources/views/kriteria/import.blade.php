@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-12 col-md-10 col-lg-8">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Import Data Kriteria
                </h4>

                <p class="text-muted mb-0">
                    Import data kriteria menggunakan file Excel.
                </p>
            </div>

            <a href="{{ route('kriteria.index') }}"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>

        {{-- ALERT ERROR --}}
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i>
            {{ session('error') }}
        </div>
        @endif

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- FORM --}}
        <div class="card shadow-sm">

            <div class="card-header text-white"
                style="background:#1f2d3d;">

                <i class="bi bi-file-earmark-excel"></i>
                Import Excel

            </div>

            <div class="card-body">

                {{-- FORMAT EXCEL --}}
                <div class="alert alert-info">

                    <strong>Format Excel:</strong>

                    <p class="mb-2 mt-2">
                        File Excel harus memiliki 4 kolom berikut:
                    </p>

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm mb-0">

                            <thead class="table-dark">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Bobot</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>K01</td>
                                    <td>Penghasilan</td>
                                    <td>0.14</td>
                                    <td>Cost</td>
                                </tr>

                                <tr>
                                    <td>K02</td>
                                    <td>Sakit Kronis</td>
                                    <td>0.28</td>
                                    <td>Benefit</td>
                                </tr>

                                <tr>
                                    <td>K03</td>
                                    <td>Lansia</td>
                                    <td>0.16</td>
                                    <td>Benefit</td>
                                </tr>

                                <tr>
                                    <td>K04</td>
                                    <td>Disabilitas</td>
                                    <td>0.17</td>
                                    <td>Benefit</td>
                                </tr>

                                <tr>
                                    <td>K05</td>
                                    <td>Jumlah Tanggungan</td>
                                    <td>0.15</td>
                                    <td>Benefit</td>
                                </tr>

                                <tr>
                                    <td>K06</td>
                                    <td>Status</td>
                                    <td>0.05</td>
                                    <td>Benefit</td>
                                </tr>

                                <tr>
                                    <td>K07</td>
                                    <td>Kondisi Rumah</td>
                                    <td>0.05</td>
                                    <td>Cost</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <small class="text-muted d-block mt-2">

                        <i class="bi bi-info-circle"></i>

                        Gunakan nama kolom:
                        <strong>kode, nama, bobot, tipe</strong>.

                        Total bobot seluruh kriteria harus 1.00.
                        Tipe hanya Benefit atau Cost.

                    </small>

                </div>

                {{-- PERINGATAN --}}
                <div class="alert alert-warning">

                    <i class="bi bi-exclamation-triangle"></i>

                    <strong>Perhatian!</strong>

                    <ul class="mb-0 mt-2">

                        <li>
                            Kode kriteria yang sudah terdaftar tidak dapat diimport kembali.
                        </li>

                        <li>
                            Jika ditemukan kode duplikat, seluruh proses import dibatalkan.
                        </li>

                        <li>
                            Data kriteria yang sudah ada tidak akan diperbarui.
                        </li>

                    </ul>

                </div>

                {{-- FORM UPLOAD --}}
                <form method="POST"
                    action="{{ route('kriteria.import') }}"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            File Excel
                        </label>

                        <input type="file"
                            name="file"
                            class="form-control @error('file') is-invalid @enderror"
                            accept=".xlsx,.xls,.csv"
                            required>

                        @error('file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <small class="text-muted">
                            Format yang diperbolehkan: XLSX, XLS, atau CSV.
                            Maksimal 5 MB.
                        </small>

                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('kriteria.index') }}"
                            class="btn btn-secondary">

                            <i class="bi bi-x-lg"></i>
                            Batal

                        </a>

                        <button type="submit"
                            class="btn btn-success">

                            <i class="bi bi-upload"></i>
                            Import Data

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection