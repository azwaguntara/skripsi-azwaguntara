@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card p-3">

            <h5 class="mb-3 fw-bold text-center">
                Tambah Data Alternatif
            </h5>

            <form action="{{ route('alternatif.store') }}" method="POST">
                @csrf

                <input type="hidden"
                    name="kelompok_id"
                    value="{{ $kelompok->id }}">

                <!-- NIK -->
                <div class="mb-3">
                    <label for="nik" class="form-label">
                        NIK
                    </label>

                    <input type="text"
                        name="nik"
                        id="nik"
                        class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik') }}"
                        maxlength="16"
                        minlength="16"
                        inputmode="numeric"
                        placeholder="Masukkan NIK 16 digit"
                        required>

                    @error('nik')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- NAMA -->
                <div class="mb-3">
                    <label for="nama" class="form-label">
                        Nama Warga
                    </label>

                    <input type="text"
                        name="nama"
                        id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama warga"
                        required>

                    @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- NO. HP -->
                <div class="mb-3">
                    <label for="no_hp" class="form-label">
                        No. HP
                    </label>

                    <input type="text"
                        name="no_hp"
                        id="no_hp"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        value="{{ old('no_hp') }}"
                        maxlength="20"
                        inputmode="numeric"
                        placeholder="Masukkan nomor HP"
                        required>

                    @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('alternatif.detail', $kelompok->id) }}"
                        class="btn btn-secondary">
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