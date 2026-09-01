@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Data Alternatif Calon Penerima Tiap Dusun
</h4>

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

    <a href="{{ route('kelompok.create') }}" class="btn btn-primary">

        <i class="bi bi-plus"></i> Tambah Data

    </a>

</div>

<div class="card p-3">

    <div class="table-responsive">

        <table class="table table-bordered table-hover">

            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Dusun</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $item)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->dusun }}
                    </td>

                    <td>
                        {{ $item->tanggal }}
                    </td>

                    <td class="text-center">




                        <a href="{{ route('alternatif.detail', $item->id) }}" class="btn btn-info btn-sm">

                            Calon Penerima

                        </a>

                        <form action="{{ route('kelompok.destroy', $item->id) }}" method="POST" class="d-inline">

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
                    <td colspan="4" class="text-center">
                        Data belum tersedia
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection