<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Hasil Perankingan
    </title>

    <style>
    /* =====================================================
           HALAMAN
        ===================================================== */

    @page {
        size: A4 landscape;
        margin: 0;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
    }

    body {
        margin: 0;
        padding: 20mm 15mm 15mm 15mm;

        background: #fff;
        color: #000;

        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
    }

    /* =====================================================
           KOP SURAT
           MENGIKUTI KOP PRINT COPRAS
        ===================================================== */

    .kop-surat {
        width: 100%;
        margin-top: 8px;
        margin-bottom: 12px;
    }

    .kop-wrapper {
        position: relative;
        width: 100%;
        min-height: 92px;
        text-align: center;
        font-family: "Times New Roman", Times, serif;
    }


    /* LOGO DI KIRI */

    .kop-logo {
        position: absolute;
        left: 0;
        top: 0;
        width: 95px;
        height: 85px;
    }

    .kop-logo img {
        width: 90px;
        height: 85px;
        object-fit: contain;
    }


    /* TEKS KOP */

    .kop-text {
        width: 100%;
        text-align: center;
        padding: 0;
        margin: 0;
    }

    .kop-text .pemerintah {
        font-size: 22px;
        font-weight: bold;
        line-height: 1.05;
        margin: 0;
    }

    .kop-text .kecamatan {
        font-size: 22px;
        font-weight: bold;
        line-height: 1.05;
        margin: 0;
    }

    .kop-text .desa {
        font-size: 31px;
        font-weight: bold;
        line-height: 1.05;
        margin-top: 3px;
    }

    .kop-text .alamat {
        font-size: 9.5px;
        line-height: 1.2;
        margin-top: 5px;
    }


    /* GARIS KOP */

    .garis-kop-1 {
        border-top: 2px solid #000;
        margin-top: 6px;
    }

    .garis-kop-2 {
        border-top: 5px solid #000;
        margin-top: 3px;
    }

    .nomor-surat {
        text-align: center;

        font-family: "Times New Roman", Times, serif;
        font-size: 10px;

        margin-top: 8px;
        margin-bottom: 6px;
    }

    /* =====================================================
           JUDUL
        ===================================================== */

    .header {
        text-align: center;
        margin-top: 13px;
        margin-bottom: 11px;
    }

    .header h3 {
        font-size: 16px;
        font-weight: bold;

        margin: 0 0 4px 0;
    }

    .header p {
        font-size: 10px;
        margin: 0;
    }


    /* =====================================================
           INFORMASI
        ===================================================== */

    .info {
        width: 100%;
        margin-bottom: 12px;

        font-size: 10px;
        line-height: 1.45;
    }

    .info div {
        margin-bottom: 2px;
    }


    /* =====================================================
           SECTION
        ===================================================== */

    .table-section {
        width: 100%;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 11px;
        font-weight: bold;

        margin-bottom: 7px;
    }


    /* =====================================================
           TABEL RANKING
        ===================================================== */

    table.ranking {
        width: 100%;

        border-collapse: collapse;
        table-layout: fixed;

        margin: 0;
    }


    /* HEADER */

    table.ranking thead {
        display: table-header-group;
    }

    table.ranking thead th {
        background-color: #212529;
        color: #fff;

        border: 1px solid #000;

        font-size: 9px;
        font-weight: bold;

        text-align: center;
        vertical-align: middle;

        padding: 6px 5px;

        height: 27px;
    }


    /* BODY */

    table.ranking tbody tr {
        page-break-inside: avoid;
    }

    table.ranking tbody td {
        border: 1px solid #000;

        font-size: 9px;

        vertical-align: middle;

        padding: 5px 6px;

        height: 24px;
    }


    /* =====================================================
           LEBAR KOLOM
        ===================================================== */

    table.ranking .ranking-col {
        width: 10%;

        text-align: center;
    }

    table.ranking .nama-col {
        width: 70%;

        text-align: left;

        padding-left: 9px !important;

        white-space: nowrap;
    }

    table.ranking .nilai-col {
        width: 20%;

        text-align: center;
    }


    /* =====================================================
           TOP 5
        ===================================================== */

    .top-five {
        background-color: #d9eadf;
    }

    .copras-section {
        margin-top: 24px;
        page-break-before: auto;
    }


    /* =====================================================
           HEADER HALAMAN LANJUTAN
        ===================================================== */

    .continuation {
        text-align: center;

        font-family: "Times New Roman", serif;

        margin-bottom: 10px;
    }

    .continuation-title {
        font-size: 14px;
        font-weight: bold;
    }

    .continuation-subtitle {
        font-size: 9px;
        margin-top: 3px;
    }


    /* =====================================================
           TANDA TANGAN
        ===================================================== */

    .signature-wrapper {
        width: 100%;

        margin-top: 28px;

        page-break-inside: avoid;
    }

    .signature {
        width: 240px;

        margin-left: auto;

        text-align: center;

        font-size: 10px;

        line-height: 1.4;
    }

    .signature-space {
        height: 60px;
    }

    .signature-name {
        margin: 0;

        font-weight: bold;

        text-decoration: underline;

        text-transform: uppercase;
    }


    /* =====================================================
           FOOTER
        ===================================================== */

    .footer {
        text-align: center;

        font-size: 8px;

        color: #555;

        margin-top: 12px;
    }


    /* =====================================================
           NOMOR SURAT / HALAMAN
        ===================================================== */

    .page-number {
        text-align: right;

        font-size: 7px;

        color: #666;

        margin-top: 5px;
    }
    </style>

</head>


<body>


    {{-- =========================================================
     KOP SURAT
========================================================= --}}

    <div class="kop-surat">

        <div class="kop-wrapper">

            {{-- LOGO --}}

            <div class="kop-logo">

                <img src="{{ public_path('images/Logo.jpeg') }}" alt="Logo Desa Sei Bamban">

            </div>


            {{-- TEKS KOP --}}

            <div class="kop-text">

                <div class="pemerintah">
                    PEMERINTAH KABUPATEN LANGKAT
                </div>

                <div class="kecamatan">
                    KECAMATAN BATANG SERANGAN
                </div>

                <div class="desa">
                    DESA SEI BAMBAN
                </div>

                <div class="alamat">
                    Alamat : Jl. Besar Batang Serangan,
                    Desa Sei Bamban, Kec. Batang Serangan
                    Kode Pos 20883
                </div>

            </div>

        </div>


        <div class="garis-kop-1"></div>

        <div class="garis-kop-2"></div>

    </div>


    {{-- =========================================================
     JUDUL
========================================================= --}}

    <div class="header">

        <h3>
            LAPORAN HASIL PERANKINGAN PENERIMA BANTUAN SOSIAL
        </h3>

        <p>
            Sistem Pendukung Keputusan Menggunakan Metode SMART dan COPRAS
        </p>

    </div>

    <div class="nomor-surat">
        Nomor :
        {{ str_pad($dataKelompok->id, 3, '0', STR_PAD_LEFT) }}/BLT-DD/DS-SB/{{ \Carbon\Carbon::now()->format('m/Y') }}
    </div>



    {{-- =========================================================
     INFORMASI
========================================================= --}}

    <div class="info">

        <div>

            <strong>Dusun</strong>
            : {{ $dataKelompok->dusun }}

        </div>


        <div>

            <strong>Tanggal</strong>
            : {{ \Carbon\Carbon::now()->format('Y-m-d') }}

        </div>

    </div>



    {{-- =========================================================
     SMART
========================================================= --}}

    <div class="table-section">


        <div class="section-title">

            1. Hasil Perankingan SMART

        </div>


        <table class="ranking">


            <colgroup>

                <col style="width: 10%;">

                <col style="width: 70%;">

                <col style="width: 20%;">

            </colgroup>


            <thead>

                <tr>

                    <th class="ranking-col">
                        Ranking
                    </th>

                    <th class="nama-col">
                        Nama Alternatif
                    </th>

                    <th class="nilai-col">
                        Nilai
                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($smart as $s)


                <tr class="{{ $s->ranking <= 5 ? 'top-five' : '' }}">


                    <td class="ranking-col">

                        <strong>
                            {{ $s->ranking }}
                        </strong>

                    </td>


                    <td class="nama-col">

                        {{ $s->alternatif->nama }}

                    </td>


                    <td class="nilai-col">

                        {{ number_format(
                            $s->nilai,
                            4,
                            '.',
                            ''
                        ) }}

                    </td>


                </tr>


                @empty


                <tr>

                    <td colspan="3" style="text-align:center;">

                        Tidak ada data

                    </td>

                </tr>


                @endforelse


            </tbody>


        </table>


    </div>



    {{-- =========================================================
     COPRAS
========================================================= --}}

    <div class="copras-section">

        <div class="table-section">


            <div class="section-title">

                2. Hasil Perankingan COPRAS

            </div>


            <table class="ranking">


                <colgroup>

                    <col style="width: 10%;">

                    <col style="width: 70%;">

                    <col style="width: 20%;">

                </colgroup>


                <thead>

                    <tr>

                        <th class="ranking-col">
                            Ranking
                        </th>

                        <th class="nama-col">
                            Nama Alternatif
                        </th>

                        <th class="nilai-col">
                            Nilai
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($copras as $c)


                    <tr class="{{ $c->ranking <= 5 ? 'top-five' : '' }}">


                        <td class="ranking-col">

                            <strong>
                                {{ $c->ranking }}
                            </strong>

                        </td>


                        <td class="nama-col">

                            {{ $c->alternatif->nama }}

                        </td>


                        <td class="nilai-col">

                            {{ number_format(
                                $c->nilai,
                                4,
                                '.',
                                ''
                            ) }}

                        </td>


                    </tr>


                    @empty


                    <tr>

                        <td colspan="3" style="text-align:center;">

                            Tidak ada data

                        </td>

                    </tr>


                    @endforelse


                </tbody>


            </table>


        </div>



        {{-- =====================================================
         TANDA TANGAN
    ====================================================== --}}

        <div class="signature-wrapper">

            <div class="signature">

                Sei Bamban,
                {{ \Carbon\Carbon::now()->format('d-m-Y') }}

                <br><br>

                Disahkan oleh,

                <br>

                <strong>
                    Kepala Desa Sei Bamban
                </strong>


                <div class="signature-space"></div>


                <div class="signature-name">
                    RUDI ARIYANTO
                </div>

                Kepala Desa Sei Bamban

            </div>

        </div>


    </div>


</body>

</html>