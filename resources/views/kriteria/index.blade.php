@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle"></i>
    {{ session('success') }}

    <button type="button"
        class="btn-close"
        data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-exclamation-circle"></i>
    {{ session('error') }}

    <button type="button"
        class="btn-close"
        data-bs-dismiss="alert"></button>
</div>
@endif

<h4 class="mb-4 fw-bold">Data Kriteria</h4>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    <div class="d-flex gap-2 flex-wrap">

        <a href="{{ route('kriteria.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i>
            Tambah Kriteria
        </a>

        <a href="{{ route('kriteria.import.form') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Import Excel
        </a>

    </div>

</div>

<div class="card p-3">

    <!-- TABLE RESPONSIVE -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Tipe</th>
                    <th>Ditambah Pada</th>
                    <th>Diedit Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $item)

                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">{{ $item->bobot }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ strtolower($item->tipe) == 'benefit' ? 'info' : 'danger' }}">
                            {{ ucfirst($item->tipe) }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="text-center">

                        <a href="{{ route('kriteria.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('kriteria.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus data ini?')">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Data belum tersedia
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection