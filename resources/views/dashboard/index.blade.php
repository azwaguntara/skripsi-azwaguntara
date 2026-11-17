@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- JUDUL -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark">
            Dashboard SPK BLT-DD Desa Sei Bamban
        </h2>

        <p class="text-muted mb-0">
            Sistem Pendukung Keputusan Penentuan Penerima Bantuan Langsung Tunai Dana Desa
        </p>
    </div>

    <!-- CARD -->
    <div class="row g-4 mb-4">

        <!-- Alternatif -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Alternatif</p>
                        <h2 class="fw-bold">{{ $alternatif }}</h2>
                    </div>

                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-people-fill text-primary fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kriteria -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Kriteria</p>
                        <h2 class="fw-bold">{{ $kriteria }}</h2>
                    </div>

                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-list-check text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dusun -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Jumlah Dusun Yang Diajukan</p>
                        <h2 class="fw-bold">{{ $dusun }} dari 17</h2>
                    </div>

                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-buildings text-warning fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- TABEL DUSUN -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 pt-4">
            <h5 class="fw-bold mb-0">
                Data Dusun & Jumlah Alternatif
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Dusun</th>
                            <th>Tanggal</th>
                            <th>Jumlah Alternatif</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($dataDusun as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="fw-semibold">
                                    {{ $item->dusun }}
                                </span>
                            </td>

                            <td>
                                {{ $item->tanggal }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $item->alternatifs_count }} Keluarga
                                </span>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="4" class="text-center">
                                Data belum tersedia
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection