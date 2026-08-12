@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">Riwayat Ranking</h4>

<!-- FILTER -->
<div class="card p-3 mb-4">
    <form method="GET">

        <div class="row g-3 align-items-end">

            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Dusun
                </label>

                <select name="kelompok" class="form-select" onchange="this.form.submit()">

                    <option value="">
                        -- Pilih Dusun --
                    </option>

                    @foreach($listKelompok as $k)

                    <option value="{{ $k->id }}" {{ $kelompok == $k->id ? 'selected' : '' }}>

                        {{ $k->dusun }}

                    </option>

                    @endforeach

                </select>

            </div>

        </div>

    </form>
</div>

<div class="row g-3">

    <!-- SMART -->
    <div class="col-12 col-lg-6">
        <div class="card p-3">

            <h5 class="fw-bold mb-3">SMART</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>Ranking</th>
                            <th>Nama</th>
                            <th>Dusun</th>
                            <th>Nilai</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($smart as $s)
                        <tr class="{{ $s->ranking == 1 ? 'table-success fw-bold' : '' }}">

                            <td>
                                @if($s->ranking == 1) 1
                                @elseif($s->ranking == 2) 2
                                @elseif($s->ranking == 3) 3
                                @else {{ $s->ranking }}
                                @endif
                            </td>

                            <td class="text-start">{{ $s->alternatif->nama }}</td>

                            <td>
                                {{ optional($s->alternatif->kelompok)->dusun }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ number_format($s->nilai, 4) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    {{ number_format($s->nilai * 100, 2) }}%
                                </span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- COPRAS -->
    <div class="col-12 col-lg-6">
        <div class="card p-3">

            <h5 class="fw-bold mb-3">COPRAS</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>Ranking</th>
                            <th>Nama</th>
                            <th>Dusun</th>
                            <th>Nilai</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $maxCopras = $copras->max('nilai');
                        @endphp
                        @forelse($copras as $c)
                        <tr class="{{ $c->ranking == 1 ? 'table-success fw-bold' : '' }}">

                            <td>
                                @if($c->ranking == 1) 1
                                @elseif($c->ranking == 2) 2
                                @elseif($c->ranking == 3) 3
                                @else {{ $c->ranking }}
                                @endif
                            </td>

                            <td class="text-start">{{ $c->alternatif->nama }}</td>

                            <td>
                                {{ optional($s->alternatif->kelompok)->dusun }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ number_format($c->nilai, 4) }}
                                </span>
                            </td>



                            <td>
                                <span class="badge bg-success">
                                    {{ $maxCopras > 0
                                                ? number_format(($c->nilai / $maxCopras) * 100, 2)
                                                : '0.00'
                                            }}%
                                </span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection