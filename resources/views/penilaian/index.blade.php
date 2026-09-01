@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Data Penilaian Tiap Dusun
</h4>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead class="table-dark text-center">

                <tr>
                    <th width="80">No</th>
                    <th>Nama Dusun</th>
                    <th width="180">Tanggal</th>
                    <th width="180">Status</th>
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

                        @if($progress[$item->id] === 'belum')

                        <span class="badge bg-secondary">
                            Belum Dimulai
                        </span>

                        @elseif($progress[$item->id] === 'proses')

                        <span class="badge bg-warning text-dark">
                            Sedang Dikerjakan
                        </span>

                        @else

                        <span class="badge bg-success">
                            Selesai
                        </span>

                        @endif

                    </td>

                    <td class="text-center">

                        <a href="{{ route('penilaian.show', $item->id) }}" class="btn btn-info btn-sm text-white">

                            Penilaian

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection