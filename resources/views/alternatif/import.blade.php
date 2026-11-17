@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-12 col-md-10 col-lg-8">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Import Data Alternatif
                </h4>

                <p class="text-muted mb-0">
                    Import data warga ke dalam dusun yang dipilih.
                </p>
            </div>

            <a href="{{ url()->previous() }}"
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

                {{-- INFORMASI DUSUN --}}
                <div class="alert alert-primary">

                    <div class="fw-semibold mb-1">
                        <i class="bi bi-geo-alt"></i>
                        Data akan diimport ke:
                    </div>

                    <strong>
                        {{ $kelompok->nama_dusun }}
                    </strong>

                </div>


                {{-- FORMAT EXCEL --}}
                <div class="alert alert-info">

                    <strong>Format Excel:</strong>

                    <p class="mb-2 mt-2">
                        File Excel harus memiliki <strong>3 kolom</strong>:
                    </p>

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm mb-0">

                            <thead class="table-dark">

                                <tr>
                                    <th>NIK</th>
                                    <th>No. HP</th>
                                    <th>Nama</th>
                                </tr>

                            </thead>

                            <tbody>

                                <tr>
                                    <td>1201234567890001</td>
                                    <td>081234567890</td>
                                    <td>Bagus</td>
                                </tr>

                                <tr>
                                    <td>1201234567890002</td>
                                    <td>081298765432</td>
                                    <td>Ageng</td>
                                </tr>

                                <tr>
                                    <td>1201234567890003</td>
                                    <td>081376543210</td>
                                    <td>Siti</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle"></i>
                        Kolom Dusun tidak perlu dimasukkan ke Excel.
                        Dusun otomatis mengikuti halaman yang sedang dibuka.
                    </small>

                </div>


                {{-- FORM UPLOAD --}}
                <form method="POST"
                    action="{{ route('alternatif.import', $kelompok->id) }}"
                    enctype="multipart/form-data">

                    @csrf


                    {{-- DUSUN --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Dusun
                        </label>

                        <input type="text"
                            class="form-control"
                            value="{{ $kelompok->nama_dusun }}"
                            readonly>

                    </div>


                    {{-- FILE --}}
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

                        <a href="{{ url()->previous() }}"
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