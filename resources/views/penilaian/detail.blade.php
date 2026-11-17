@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Matriks Penilaian - {{ $kelompok->dusun }}
</h4>


{{-- =========================================================
     ALERT STATUS PENILAIAN
     ========================================================= --}}

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


{{-- =========================================================
     TOMBOL IMPORT EXCEL
     ========================================================= --}}

<div class="d-flex justify-content-end mb-3">

    <a href="{{ route('penilaian.import.form', $kelompok->id) }}"
        class="btn btn-success">

        <i class="bi bi-file-earmark-excel"></i>
        Import Excel

    </a>

</div>


{{-- =========================================================
     TABEL PENILAIAN
     ========================================================= --}}

<div class="card p-3 mb-4">

    <form method="POST"
        action="{{ route('penilaian.store') }}"
        id="formPenilaian">

        @csrf

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">

                    <tr>

                        <th style="min-width: 150px;">
                            Alternatif
                        </th>

                        @foreach($kriterias as $k)

                        <th style="min-width: 260px;">
                            {{ $k->nama }}
                        </th>

                        @endforeach

                    </tr>

                </thead>


                <tbody>

                    @foreach($alternatifs as $a)

                    <tr>

                        {{-- =================================================
                                 NAMA ALTERNATIF
                                 ================================================= --}}

                        <td class="fw-semibold">
                            {{ $a->nama }}
                        </td>


                        {{-- =================================================
                                 NILAI KRITERIA
                                 ================================================= --}}

                        @foreach($kriterias as $k)

                        @php

                        $key = $a->id . '-' . $k->id;

                        $nilai = $penilaians->get($key);

                        $opsi = $opsiPenilaian[$k->nama] ?? [];

                        @endphp


                        <td style="min-width: 260px;">

                            <select
                                name="nilai[{{ $a->id }}][{{ $k->id }}]"
                                class="form-select nilai-input">

                                {{-- PILIHAN DEFAULT --}}
                                <option value="">
                                    -- Pilih {{ $k->nama }} --
                                </option>


                                {{-- DAFTAR OPSI --}}
                                @foreach($opsi as $value => $label)

                                <option
                                    value="{{ $value }}"
                                    {{ $nilai && (int) $nilai->nilai === (int) $value ? 'selected' : '' }}>

                                    {{ $value }} - {{ $label }}

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


        {{-- =========================================================
             TOMBOL AKSI
             ========================================================= --}}

        <div class="mt-3 d-flex justify-content-end gap-2">

            {{-- LANJUT NANTI --}}
            <button type="submit"
                name="aksi"
                value="lanjut"
                class="btn btn-secondary">

                <i class="bi bi-clock"></i>
                Lanjut Nanti

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


{{-- =============================================================
     JAVASCRIPT CEK KELENGKAPAN
     ============================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const inputs = document.querySelectorAll(
            'select[name^="nilai["]'
        );

        const btnSelesaikan =
            document.getElementById('btnSelesaikan');


        function cekKelengkapan() {

            let lengkap = true;

            inputs.forEach(function(input) {

                if (input.value.trim() === '') {

                    lengkap = false;

                }

            });


            btnSelesaikan.disabled = !lengkap;

        }


        // Cek ketika halaman pertama dibuka
        cekKelengkapan();


        // Cek ketika dropdown berubah
        inputs.forEach(function(input) {

            input.addEventListener('change', function() {

                cekKelengkapan();

            });

        });

    });
</script>