@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Matriks Penilaian - {{ $kelompok->dusun }}
</h4>

<div class="card p-3 mb-4">

    <form method="POST" action="{{ route('penilaian.store') }}">
        @csrf

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">

                    <tr>

                        <th>Alternatif</th>

                        @foreach($kriterias as $k)

                        <th>
                            {{ $k->nama }}
                        </th>

                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @foreach($alternatifs as $a)

                    <tr>

                        <td class="fw-semibold">
                            {{ $a->nama }}
                        </td>

                        @foreach($kriterias as $k)

                        @php

                        /*
                        |--------------------------------------------------------------------------
                        | Ambil nilai secara langsung berdasarkan
                        | kombinasi alternatif + kriteria
                        |--------------------------------------------------------------------------
                        */

                        $key = $a->id . '-' . $k->id;

                        $nilai = $penilaians->get($key);

                        @endphp

                        <td style="min-width: 120px;">

                            <input
                                type="number"
                                step="0.01"
                                name="nilai[{{ $a->id }}][{{ $k->id }}]"
                                class="form-control text-center"
                                value="{{ $nilai ? rtrim(rtrim(number_format($nilai->nilai, 2, '.', ''), '0'), '.') : '' }}">

                        </td>

                        @endforeach

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-3 text-end">

            <button type="submit" class="btn btn-primary">

                Simpan Penilaian

            </button>

        </div>

    </form>

</div>

@endsection