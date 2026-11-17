@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Perhitungan COPRAS Tiap Dusun
</h4>

@if(session('error'))

<div class="alert alert-danger">
    {{ session('error') }}
</div>

@endif

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        {{-- RESPONSIVE TABLE --}}
        <div class="table-responsive">

            <table class="table table-bordered align-middle mb-0">

                <thead class="table-dark text-center">

                    <tr>
                        <th width="70">No</th>
                        <th>Nama Dusun</th>
                        <th width="150">Tanggal</th>
                        <th width="150">Status</th>
                        <th width="180">Terakhir Diproses</th>
                        <th width="180">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($kelompoks as $item)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->dusun }}
                        </td>

                        <td>
                            {{ $item->tanggal }}
                        </td>

                        <td class="text-center">

                            @if($item->copras_processed_at)

                            <span class="badge bg-success">
                                Sudah Diproses
                            </span>

                            @else

                            <span class="badge bg-warning text-dark">
                                Belum Diproses
                            </span>

                            @endif

                        </td>

                        <td class="text-center">

                            @if($item->copras_processed_at)

                            {{ \Carbon\Carbon::parse($item->copras_processed_at)->format('d-m-Y H:i') }}

                            @else

                            -

                            @endif

                        </td>

                        <td class="text-center">

                            <a href="{{ route('copras.show', $item->id) }}"
                                class="btn btn-info btn-sm text-white">

                                Hitung COPRAS

                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection