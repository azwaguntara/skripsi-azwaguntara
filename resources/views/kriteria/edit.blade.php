@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card p-3">

            <h5 class="mb-3 fw-bold text-center">Edit Data Kriteria</h5>

            <form action="{{ route('kriteria.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- KODE -->
                <div class="mb-3">
                    <label class="form-label">Kode Kriteria</label>
                    <input type="text" name="kode" class="form-control"
                        value="{{ $data->kode }}" required>
                </div>

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label">Nama Kriteria</label>
                    <input type="text" name="nama" class="form-control"
                        value="{{ $data->nama }}" required>
                </div>

                <!-- BOBOT -->
                <div class="mb-3">
                    <label class="form-label">Bobot</label>
                    <input type="number" step="0.01" name="bobot" class="form-control"
                        value="{{ $data->bobot }}" required>
                </div>

                <!-- TIPE -->
                <div class="mb-4">
                    <label class="form-label">Tipe</label>
                    <select name="tipe" class="form-select">
                        <option value="benefit" {{ $data->tipe == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ $data->tipe == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection