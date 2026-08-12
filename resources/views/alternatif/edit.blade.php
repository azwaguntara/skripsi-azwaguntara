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

                    <input type="hidden" name="kelompok_id" value="{{ $data->kelompok_id }}">

                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input type="text" name="nama" value="{{ $data->nama }}" class="form-control" required>

                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-between">

                        <a href="{{ route('alternatif.detail', $data->kelompok_id) }}" class="btn btn-secondary">
                            ← Kembali
                        </a>

                        <button class="btn btn-primary">

                            <i class="bi bi-save"></i>
                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection