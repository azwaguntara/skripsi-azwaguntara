@extends('layouts.app')

@section('content')

    <h4 class="mb-4 fw-bold">
        Data Alternatif - {{ $kelompok->dusun }}
    </h4>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

        <a href="{{ route('alternatif.create', $kelompok->id) }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Alternatif
        </a>

    </div>

    <div class="card p-3">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($kelompok->alternatifs as $item)

                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->nama }}
                            </td>



                            <td class="text-center">

                                <a href="{{ route('alternatif.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('alternatif.destroy', $item->id) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">

                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center text-muted">

                                Data alternatif belum tersedia

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

@endsection