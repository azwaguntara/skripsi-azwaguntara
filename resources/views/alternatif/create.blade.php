@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card p-3">

                <h5 class="mb-3 fw-bold text-center">Tambah Data Alternatif</h5>

                <form action="{{ route('alternatif.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label">Nama Warga</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>

                    



                    <!-- BUTTON -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('alternatif.index') }}" class="btn btn-secondary">
                            ← Kembali
                        </a>

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection