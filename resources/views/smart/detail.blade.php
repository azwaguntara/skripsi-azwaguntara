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
                            <th>Status</th>
                            <th>Tanggal Penetapan</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($hasil as $h)

                        <tr class="{{ $h['ranking'] <= 5 ? 'table-success' : '' }}">

                            {{-- RANKING --}}
                            <td>
                                <strong>{{ $h['ranking'] }}</strong>
                            </td>

                            {{-- ALTERNATIF --}}
                            <td>
                                <strong>{{ $h['nama'] }}</strong>
                            </td>

                            {{-- NILAI --}}
                            <td>
                                {{ round($h['nilai'], 4) }}
                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($h['status'] == 'Ditetapkan')

                                <span class="badge bg-primary px-3 py-2">
                                    Ditetapkan
                                </span>

                                @elseif($h['ranking'] <= 5)

                                    <span class="badge bg-success px-3 py-2">
                                    Direkomendasikan
                                    </span>

                                    @elseif($h['ranking'] <= 10)

                                        <span class="badge bg-warning text-dark px-3 py-2">
                                        Dapat Dipertimbangkan
                                        </span>

                                        @else

                                        <span class="badge bg-secondary px-3 py-2">
                                            Tidak Direkomendasikan
                                        </span>

                                        @endif

                            </td>

                            <td>
                                @if($h['status'] == 'Ditetapkan' && !empty($h['tanggal_penetapan']))
                                {{ \Carbon\Carbon::parse($h['tanggal_penetapan'])->format('d-m-Y H:i') }}
                                @else
                                -
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td>

                                @if($h['status'] == 'Ditetapkan')

                                <form
                                    action="{{ route('smart.batalTetapkan', $h['smart_id']) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Batalkan penetapan {{ $h['nama'] }} sebagai penerima bantuan?')">

                                        <i class="bi bi-x-circle"></i>
                                        Batal Penetapan

                                    </button>

                                </form>

                                @else

                                <form
                                    action="{{ route('smart.tetapkan', $h['smart_id']) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-sm"
                                        onclick="return confirm('Tetapkan {{ $h['nama'] }} sebagai penerima bantuan?')">

                                        <i class="bi bi-check-circle"></i>
                                        Tetapkan

                                    </button>

                                </form>

                                @endif
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