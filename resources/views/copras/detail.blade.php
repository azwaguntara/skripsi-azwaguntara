@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">Perhitungan COPRAS</h4>

<!-- 1. Matriks -->
<div class="card mb-4">
    <div class="card-header custom-header">Matriks Keputusan</div>
    <div class="card-body">

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
                        <td class="fw-semibold">{{ $a->nama }}</td>
                        @foreach($kriterias as $k)
                        <td style="min-width:120px;" class="text-center">
                            {{ number_format($matrix[$a->id][$k->id], 0) }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- 2. Normalisasi -->
<div class="card mb-4">
    <div class="card-header custom-header">Normalisasi</div>
    <div class="card-body">

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
                        <td class="fw-semibold">{{ $a->nama }}</td>
                        @foreach($kriterias as $k)
                        <td style="min-width:120px;" class="text-center">
                            {{ number_format($normal[$a->id][$k->id], 4) }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- 3. Terbobot -->
<div class="card mb-4">
    <div class="card-header custom-header">Normalisasi Terbobot</div>
    <div class="card-body">

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
                        <td class="fw-semibold">{{ $a->nama }}</td>
                        @foreach($kriterias as $k)
                        <td style="min-width:120px;" class="text-center">
                            {{ number_format($terbobot[$a->id][$k->id], 4) }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- 4. S+ dan S- -->
<div class="card mb-4">
    <div class="card-header custom-header">Nilai S+ dan S-</div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Alternatif</th>
                        <th>S+</th>
                        <th>S-</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($alternatifs as $a)
                    <tr>
                        <td class="fw-semibold text-start">{{ $a->nama }}</td>
                        <td>{{ number_format($splus[$a->id], 4) }}</td>
                        <td>{{ number_format($sminus[$a->id], 4) }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- 5. Ranking -->
<div class="card mb-4">
    <div class="card-header custom-header">Ranking</div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Alternatif</th>
                        <th>Qi</th>
                        <th>Ui (%)</th>
                        <th>Ranking</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($hasil as $i => $h)
                    <tr class="{{ $i == 0 ? 'table-success fw-bold' : '' }}">
                        <td class="text-start">{{ $h['nama'] }}</td>
                        <td>{{ number_format($h['qi'], 4) }}</td>
                        <td>{{ number_format($h['ui'], 2) }}%</td>
                        <td>
                            @if($i == 0) 1
                            @elseif($i == 1) 2
                            @elseif($i == 2) 3
                            @else {{ $i + 1 }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">

            <a href="{{ route('copras.print', $kelompok->id) }}" target="_blank" class="btn btn-danger">

                <i class="bi bi-printer"></i>
                Print

            </a>

        </div>

    </div>
</div>

@endsection