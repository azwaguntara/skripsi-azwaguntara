@extends('layouts.app')

@section('content')

    <h4 class="mb-4 fw-bold">
        Tambah Data Dusun
    </h4>

    <div class="card p-4">

        <form action="{{ route('kelompok.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">Dusun</label>
                <select name="dusun" class="form-select" required>

                    <option value="">
                        -- Pilih Dusun --
                    </option>

                    @foreach($dusunList as $dusun)

                        <option value="{{ $dusun }}" {{ old('dusun') == $dusun ? 'selected' : '' }}>

                            {{ $dusun }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>

                <input type="date" name="tanggal" class="form-control">
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>

@endsection