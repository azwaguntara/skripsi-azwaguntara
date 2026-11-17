@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Data Alternatif - {{ $kelompok->dusun }}
</h4>

{{-- PESAN SUCCESS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle"></i>
    {{ session('success') }}

    <button type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>
</div>
@endif

{{-- PESAN ERROR --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle"></i>
    {{ session('error') }}

    <button type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    <div class="d-flex gap-2 mb-3">

        <a href="{{ route('alternatif.create', $kelompok->id) }}"
            class="btn btn-primary">

            <i class="bi bi-plus-lg"></i>
            Tambah Alternatif

        </a>

        <a href="{{ route('alternatif.import.form', $kelompok->id) }}"
            class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Import Excel
        </a>

    </div>

</div>

<div class="card p-3">

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($kelompok->alternatifs as $item)

                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ $item->nik ?? '-' }}
                    </td>

                    <td>
                        {{ $item->nama }}
                    </td>

                    <td class="text-center">
                        {{ $item->no_hp ?? '-' }}
                    </td>

                    <td class="text-center">

                        <a href="{{ route('alternatif.edit', $item->id) }}"
                            class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('alternatif.destroy', $item->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <input type="hidden"
                                name="kelompok_id"
                                value="{{ $kelompok->id }}">

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus data ini?')">
                                Hapus
                            </button>

                        </form>

                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Data alternatif belum tersedia
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection