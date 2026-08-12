@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Matriks Penilaian - {{ $kelompok->dusun }}
</h4>

<div class="card p-3 mb-4">

    <form method="POST" action="{{route('penilaian.store')}}">
        @csrf

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">

                    <tr>

                        <th>Alternatif</th>

                        @foreach($kriterias as $k)
                            <th>{{ $k->nama }}</th>
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
                                    $nilai = $penilaians
                                        ->where('alternatif_id', $a->id)
                                        ->where('kriteria_id', $k->id)
                                        ->first();
                                @endphp

                                <td style="min-width: 120px;">

                                    <input type="number"
                                        step="0.01"
                                        name="nilai[{{$a->id}}][{{$k->id}}]"
                                        class="form-control text-center"
                                        value="{{ $nilai ? $nilai->nilai : '' }}">

                                </td>

                            @endforeach

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-3 text-end">

            <button class="btn btn-primary">
                Simpan Penilaian
            </button>

        </div>

    </form>

</div>

@endsection