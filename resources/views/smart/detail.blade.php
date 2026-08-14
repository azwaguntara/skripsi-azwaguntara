@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Perhitungan SMART</h3>


    <!-- 1. Kriteria -->
    <div class="card mb-4">

        <div class="card-header custom-header">
            Data Kriteria & Bobot
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark text-center">

                        <tr>
                            <th>Kriteria</th>
                            <th>Bobot</th>
                            <th>Normalisasi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($kriterias as $k)

                        <tr>

                            <td>
                                {{ $k->nama }}
                            </td>

                            <td class="text-center">
                                {{ $k->bobot }}
                            </td>

                            <td class="text-center">
                                {{ round($k->normalisasi, 3) }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- 2. Matriks -->
    <div class="card mb-4">

        <div class="card-header custom-header">
            Matriks Penilaian
        </div>

        <div class="card-body">

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

                        @foreach($alternatifs as $alt)

                        <tr>

                            <td class="fw-semibold">
                                {{ $alt->nama }}
                            </td>

                            @foreach($kriterias as $k)

                            <td
                                style="min-width:120px;"
                                class="text-center">
                                {{ number_format(
                                    $matrix[$alt->id][$k->id] ?? 0,
                                    0
                                ) }}
                            </td>

                            @endforeach

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- 3. Min Max -->
    <div class="card mb-4">

        <div class="card-header custom-header">
            Nilai Min & Max
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark text-center">

                        <tr>
                            <th>Kriteria</th>
                            <th>Min</th>
                            <th>Max</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($minmax as $k => $mm)

                        <tr>

                            <td>
                                {{ $mm['nama'] }}
                            </td>

                            <td class="text-center">
                                {{ number_format($mm['min'], 0) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($mm['max'], 0) }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- 4. Utility -->
    <div class="card mb-4">

        <div class="card-header custom-header">
            Matriks Utility
        </div>

        <div class="card-body">

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

                        @foreach($alternatifs as $alt)

                        <tr>

                            <td class="fw-semibold">
                                {{ $alt->nama }}
                            </td>

                            @foreach($kriterias as $k)

                            @php
                            $utilityData =
                            $detail[$alt->id][$k->id] ?? null;
                            @endphp

                            <td
                                style="min-width:120px;"
                                class="text-center">

                                @if(
                                $utilityData &&
                                $utilityData['utility'] !== null
                                )

                                {{ round(
                                        $utilityData['utility'],
                                        3
                                    ) }}

                                @else

                                0

                                @endif

                            </td>

                            @endforeach

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- 5. Hasil -->
    <div class="card mb-4">

        <div class="card-header custom-header">
            Hasil Perhitungan SMART
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-striped text-center align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>Ranking</th>
                            <th>Alternatif</th>
                            <th>Nilai</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($hasil as $index => $h)

                        <tr class="{{ $index == 0 ? 'table-success fw-bold' : '' }}">

                            <td>
                                {{ $h['ranking'] }}
                            </td>

                            <td>
                                {{ $h['nama'] }}
                            </td>

                            <td>
                                {{ round($h['nilai'], 4) }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>


            <div class="d-flex justify-content-end mt-3">

                <a
                    href="{{ route('smart.print', $kelompok->id) }}"
                    target="_blank"
                    class="btn btn-danger">

                    <i class="bi bi-printer"></i>
                    Print

                </a>

            </div>

        </div>

    </div>

</div>

@endsection