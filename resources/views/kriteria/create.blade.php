@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card p-3">

            <h5 class="mb-3 fw-bold text-center">Tambah Data Kriteria</h5>

            <!-- ALERT SUCCESS -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('kriteria.store') }}" method="POST">
                @csrf

                <!-- KODE -->
                <div class="mb-3">
                    <label class="form-label">Kode Kriteria</label>
                    <input type="text" name="kode" class="form-control"
                        value="{{ old('kode') }}" required>

                    @error('kode')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label">Nama Kriteria</label>
                    <input type="text" name="nama" class="form-control"
                        value="{{ old('nama') }}" required>

                    @error('nama')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BOBOT -->
                <div class="mb-3">
                    <label class="form-label">Bobot</label>
                    <input type="number" step="0.01" name="bobot" class="form-control"
                        value="{{ old('bobot') }}" required>

                    @error('bobot')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TIPE -->
                <div class="mb-4">
                    <label class="form-label">Tipe</label>
                    <select name="tipe" class="form-select">
                        <option value="benefit" {{ old('tipe') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('tipe') == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>

                    @error('tipe')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection