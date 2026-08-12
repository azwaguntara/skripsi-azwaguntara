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
                                    <td>{{ $k->nama }}</td>
                                    <td class="text-center">{{ $k->bobot }}</td>
                                    <td class="text-center">{{ round($k->normalisasi, 3) }}</td>
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
                                    <th>{{ $k->nama }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($alternatifs as $alt)
                                <tr>
                                    <td class="fw-semibold">{{ $alt->nama }}</td>

                                    @foreach($kriterias as $k)
                                        <td style="min-width:120px;" class="text-center">
                                            {{ $matrix[$alt->id][$k->id] ?? 0 }}
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
                                    <td>{{ $mm['nama'] }}</td>
                                    <td class="text-center">{{ $mm['min'] }}</td>
                                    <td class="text-center">{{ $mm['max'] }}</td>
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
                                    <th>{{ $k->nama }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($alternatifs as $alt)
                                <tr>
                                    <td class="fw-semibold">{{ $alt->nama }}</td>

                                    @foreach($kriterias as $k)
                                        @php
                                            $nilai = $matrix[$alt->id][$k->id];
                                            $min = $minmax[$k->id]['min'];
                                            $max = $minmax[$k->id]['max'];

                                            if ($max == $min) {
                                                $u = 1;
                                            } else {
                                                $u = $k->tipe == 'benefit'
                                                    ? ($nilai - $min) / ($max - $min)
                                                    : ($max - $nilai) / ($max - $min);
                                            }
                                        @endphp

                                        <td style="min-width:120px;" class="text-center">
                                            {{ round($u, 3) }}
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
                                        @if($index == 0) 🥇
                                        @elseif($index == 1) 🥈
                                        @elseif($index == 2) 🥉
                                        @else {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>{{ $h['nama'] }}</td>
                                    <td>{{ round($h['nilai'], 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                

                <div class="d-flex justify-content-end mt-3">

                    <a
                        href="{{ route('smart.print', $kelompok->id) }}"
                        target="_blank"
                        class="btn btn-danger"
                    >

                        <i class="bi bi-printer"></i>
                        Print

                    </a>

                </div>

            </div>
        </div>

        

        

        <!-- 6. Detail -->
        <div class="card mb-4">
            <div class="card-header custom-header">
                Detail Perhitungan SMART
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark text-center">
                            <tr>
                                <th>Alternatif</th>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                                <th>Utility</th>
                                <th>Bobot</th>
                                <th>Utility x Bobot</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($detail as $nama => $data)

                                @php $total = 0; @endphp

                                @foreach($data as $i => $d)
                                    @php 
                                                                    $hasil = $d['utility'] * $d['bobot'];
                                        $total += $hasil;
                                    @endphp
                                      <tr>
                                      @if($i == 0)
                                        <td rowspan="{{ count($data) + 1 }}" class="fw-bold align-middle">
                                                    {{ $nama }}
                                        </td>
                                    @endif
                                        <td>{{ $d['kriteria'] }}</td>
                                        <td class="text-center">{{ $d['nilai'] }}</td>
                                        <td class="text-center">{{ round($d['utility'], 3) }}</td>
                                                <td class="text-center">{{ round($d['bobot'], 3) }}</td>
                                            <td class="text-center">{{ round($hasil, 3) }}</td>
                                            </tr>

                                   @endforeach

                                <tr class="table-success fw-bold text-center">
                                        <td colspan="4">Total</td>
                                        <td>{{ round($total, 3) }}</td>
                                    </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection