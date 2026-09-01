@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Matriks Penilaian - {{ $kelompok->dusun }}
</h4>

@if($totalData == 0)

<div class="alert alert-info">
    <i class="bi bi-info-circle"></i>
    <strong>Belum Ada Data Alternatif</strong>
    <br>
    Dusun ini belum memiliki calon penerima yang dapat dinilai.
</div>

@elseif($penilaianLengkap)

<div class="alert alert-success">
    <i class="bi bi-check-circle"></i>
    <strong>Penilaian Lengkap</strong>
    <br>
    Seluruh data penilaian telah diisi.
</div>

@else

<div class="alert alert-warning">
    <i class="bi bi-exclamation-circle"></i>
    <strong>Penilaian Belum Lengkap</strong>
    <br>
    {{ $totalTerisi }} dari {{ $totalData }} data penilaian telah diisi.
    Anda dapat menyimpan dan melanjutkannya kembali nanti.
</div>

@endif

<div class="card p-3 mb-4">

    <form method="POST" action="{{ route('penilaian.store') }}">
        @csrf

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

                    @foreach($alternatifs as $a)

                    <tr>

                        <td class="fw-semibold">
                            {{ $a->nama }}
                        </td>

                        @foreach($kriterias as $k)

                        @php

                        /*
                        |--------------------------------------------------------------------------
                        | Ambil nilai secara langsung berdasarkan
                        | kombinasi alternatif + kriteria
                        |--------------------------------------------------------------------------
                        */

                        $key = $a->id . '-' . $k->id;

                        $nilai = $penilaians->get($key);

                        @endphp

                        <td style="min-width: 250px;">

                            <select
                                name="nilai[{{ $a->id }}][{{ $k->id }}]"
                                class="form-select">

                                <option value="">
                                    -- Pilih Penilaian --
                                </option>

                                @foreach($opsiPenilaian[$k->nama] ?? [] as $skor => $deskripsi)

                                <option value="{{ $skor }}"
                                    {{ $nilai !== null && $nilai->nilai == $skor ? 'selected' : '' }}>
                                    {{ $deskripsi }}
                                </option>

                                @endforeach

                            </select>

                        </td>

                        @endforeach

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-3 d-flex justify-content-end gap-2">

            {{-- LANJUT NANTI --}}
            <button type="submit"
                name="aksi"
                value="lanjut"
                class="btn btn-secondary">

                <i class="bi bi-clock"></i> Lanjut Nanti
            </button>

            {{-- SELESAIKAN PENILAIAN --}}
            <button type="submit"
                name="aksi"
                value="simpan"
                id="btnSelesaikan"
                class="btn btn-primary"
                {{ !$penilaianLengkap ? 'disabled' : '' }}>

                <i class="bi bi-check-circle"></i>
                Selesaikan Penilaian
            </button>

        </div>


    </form>

</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const selects = document.querySelectorAll(
            'select[name^="nilai["]'
        );

        const btnSelesaikan = document.getElementById(
            'btnSelesaikan'
        );

        function cekKelengkapan() {

            let lengkap = true;

            selects.forEach(function(select) {

                if (select.value === '') {
                    lengkap = false;
                }

            });

            btnSelesaikan.disabled = !lengkap;
        }

        // Jalankan saat halaman pertama dibuka
        cekKelengkapan();

        // Cek setiap kali dropdown berubah
        selects.forEach(function(select) {

            select.addEventListener('change', function() {
                cekKelengkapan();
            });

        });

    });
</script>