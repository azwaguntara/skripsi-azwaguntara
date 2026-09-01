@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4 fw-bold">
        Daftar Penerima Bantuan
    </h4>

    <div class="card">

        <div class="card-body">

            <form method="GET" action="{{ route('penerima.index') }}" class="mb-4">

                <div class="row g-3 align-items-end">

                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Dusun
                        </label>

                        <select name="kelompok_id" class="form-select">

                            <option value="">
                                Semua Dusun
                            </option>

                            @foreach($kelompoks as $kelompok)

                            <option
                                value="{{ $kelompok->id }}"
                                {{ $kelompokId == $kelompok->id ? 'selected' : '' }}>
                                {{ $kelompok->dusun }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-auto">

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                        <a href="{{ route('penerima.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset
                        </a>

                    </div>

                    <div class="col-md-auto ms-auto">

                        <a
                            href="{{ route('penerima.print', ['kelompok_id' => $kelompokId]) }}"
                            target="_blank"
                            class="btn btn-outline-dark">
                            <i class="bi bi-printer"></i>
                            Cetak
                        </a>

                        <a
                            href="{{ route('penerima.pdf', ['kelompok_id' => $kelompokId]) }}"
                            class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Download PDF
                        </a>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-dark">

                        <tr>
                            <th>No</th>
                            <th>Nama Penerima</th>
                            <th>Dusun</th>
                            <th>Ranking SMART</th>
                            <th>Nilai SMART</th>
                            <th>Ranking COPRAS</th>
                            <th>Nilai COPRAS</th>
                            <th>Metode Penetapan</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($penerima as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td class="fw-semibold">
                                {{ $item['nama'] }}
                            </td>

                            <td>
                                {{ $item['dusun'] }}
                            </td>

                            <td>
                                {{ $item['ranking_smart'] ?? '-' }}
                            </td>

                            <td>
                                {{ $item['nilai_smart'] !== null
                                        ? number_format($item['nilai_smart'], 4)
                                        : '-' }}
                            </td>

                            <td>
                                {{ $item['ranking_copras'] ?? '-' }}
                            </td>

                            <td>
                                {{ $item['nilai_copras'] !== null
                                        ? number_format($item['nilai_copras'], 4)
                                        : '-' }}
                            </td>

                            <td>

                                @if($item['metode'] == 'SMART & COPRAS')

                                <span class="badge bg-primary px-3 py-2">
                                    SMART & COPRAS
                                </span>

                                @elseif($item['metode'] == 'SMART')

                                <span class="badge bg-success px-3 py-2">
                                    SMART
                                </span>

                                @else

                                <span class="badge bg-info px-3 py-2">
                                    COPRAS
                                </span>

                                @endif

                            </td>

                            <td>

                                <span class="badge bg-primary px-3 py-2">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Ditetapkan
                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="9" class="text-center py-4">

                                <span class="text-muted">
                                    Belum ada penerima bantuan yang ditetapkan.
                                </span>

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