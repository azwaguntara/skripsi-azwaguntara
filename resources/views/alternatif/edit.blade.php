@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card p-3">

            <h5 class="mb-3 fw-bold text-center">
                Edit Data Alternatif
            </h5>

            <form action="{{ route('alternatif.update', $data->id) }}" method="POST">

                @csrf
                @method('PUT')

                <input type="hidden"
                    name="kelompok_id"
                    value="{{ $data->kelompok_id }}">

                <!-- NIK -->
                <div class="mb-3">

                    <label class="form-label">
                        NIK
                    </label>

                    <input type="text"
                        name="nik"
                        value="{{ old('nik', $data->nik) }}"
                        class="form-control"
                        maxlength="16"
                        required>

                    @error('nik')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <!-- NAMA -->
                <div class="mb-3">

                    <label class="form-label">
                        Nama
                    </label>

                    <input type="text"
                        name="nama"
                        value="{{ old('nama', $data->nama) }}"
                        class="form-control"
                        required>

                    @error('nama')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <!-- NO. HP -->
                <div class="mb-3">

                    <label class="form-label">
                        No. HP
                    </label>

                    <input type="text"
                        name="no_hp"
                        value="{{ old('no_hp', $data->no_hp) }}"
                        class="form-control"
                        maxlength="20"
                        inputmode="numeric"
                        placeholder="Masukkan nomor HP"
                        required>

                    @error('no_hp')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">

                    <a href="{{ route('alternatif.detail', $data->kelompok_id) }}"
                        class="btn btn-secondary">
                        ← Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

@endsection