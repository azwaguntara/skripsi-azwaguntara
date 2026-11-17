@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">Riwayat Ranking</h4>

<!-- FILTER -->
<div class="card p-3 mb-4">

    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">

        <form method="GET" class="m-0">

            <div class="row g-3 align-items-end">

                <div class="col-md-12">

                    <label class="form-label fw-semibold">
                        Dusun
                    </label>

                    <select name="kelompok"
                            class="form-select"
                            onchange="this.form.submit()">

                        <option value="">
                            -- Pilih Dusun --
                        </option>

                        @foreach($listKelompok as $k)

                            <option value="{{ $k->id }}"
                                {{ $kelompok == $k->id ? 'selected' : '' }}>

                                {{ $k->dusun }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </form>


        @if($kelompok)

            <a href="{{ route('riwayat.downloadPdf', ['kelompok' => $kelompok]) }}"
               class="btn btn-danger">

                <i class="bi bi-file-earmark-pdf-fill"></i>
                Download PDF

            </a>

        @endif

    </div>

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
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($smart as $s)

                        <tr class="{{ $s['ranking'] <= 5 ? 'table-success' : '' }}">

                        

                            <td>
                                <strong>{{ $s->ranking }}</strong>
                            </td>

                            <td class="text-start">
                                {{ $s->alternatif->nama }}
                            </td>

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

                            <td>

                                @if($s->ranking <= 5)

                                    <span class="badge bg-success px-3 py-2">
                                    Direkomendasikan
                                    </span>

                                    @elseif($s->ranking <= 10)

                                        <span class="badge bg-warning text-dark px-3 py-2">
                                        Dapat Dipertimbangkan
                                        </span>

                                        @else

                                        <span class="badge bg-secondary px-3 py-2">
                                            Tidak Direkomendasikan
                                        </span>

                                        @endif

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-muted">
                                Tidak ada data
                            </td>
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
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        @php
                        $maxCopras = $copras->max('nilai');
                        @endphp

                        @forelse($copras as $c)

                        <tr class="{{ $c['ranking'] <= 5 ? 'table-success' : '' }}">

                            <td>
                                <strong>{{ $c->ranking }}</strong>
                            </td>

                            <td class="text-start">
                                {{ $c->alternatif->nama }}
                            </td>

                            <td>
                                {{ optional($c->alternatif->kelompok)->dusun }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ number_format($c->nilai, 4) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success">

                                    {{
                                        $maxCopras > 0
                                            ? number_format(
                                                ($c->nilai / $maxCopras) * 100,
                                                2
                                            )
                                            : '0.00'
                                    }}%

                                </span>
                            </td>

                            <td>

                                @if($c->ranking <= 5)

                                    <span class="badge bg-success px-3 py-2">
                                    Direkomendasikan
                                    </span>

                                    @elseif($c->ranking <= 10)

                                        <span class="badge bg-warning text-dark px-3 py-2">
                                        Dapat Dipertimbangkan
                                        </span>

                                        @else

                                        <span class="badge bg-secondary px-3 py-2">
                                            Tidak Direkomendasikan
                                        </span>

                                        @endif

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-muted">
                                Tidak ada data
                            </td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection