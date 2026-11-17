<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Perhitungan SMART - BLT-DD Desa Sei Bamban
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 40px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            background: #fff;
        }

        .container-fluid {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        /* =========================
   KOP SURAT
========================= */

        .kop-surat {
            width: 100%;
            margin-bottom: 12px;
        }

        .kop-wrapper {
            width: 100%;
            display: table;
        }

        .kop-logo {
            display: table-cell;
            width: 145px;
            vertical-align: middle;
            text-align: left;
        }

        .kop-logo img {
            width: 125px;
            height: auto;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding-right: 125px;
            font-family: "Times New Roman", serif;
        }

        .kop-text .pemerintah {
            font-size: 27px;
            font-weight: bold;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        .kop-text .kecamatan {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        .kop-text .desa {
            font-size: 40px;
            font-weight: bold;
            line-height: 1.05;
            margin-top: 3px;
        }

        .kop-text .alamat {
            font-size: 14px;
            margin-top: 6px;
            line-height: 1.2;
        }

        /* GARIS KOP DUA LAPIS */

        .garis-kop-1 {
            border-top: 2px solid #000;
            margin-top: 8px;
        }

        .garis-kop-2 {
            border-top: 5px solid #000;
            margin-top: 3px;
        }

        /* JUDUL */

        .header {
            text-align: center;
            margin-top: 18px;
            margin-bottom: 10px;
        }

        .header h3 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .header p {
            margin: 0;
            font-size: 11px;
        }

        /* NOMOR SURAT */

        .nomor-surat {
            text-align: center;
            font-size: 11px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* INFORMASI */

        .info {
            margin-bottom: 16px;
            font-size: 11px;
            line-height: 1.5;
        }

        /* JUDUL SECTION */

        .section-title {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        /* =========================
       TABEL
    ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        th,
        td {
            border: 1px solid #000 !important;
            padding: 5px 6px !important;
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
            line-height: 1.25;
        }

        thead {
            display: table-header-group;
        }

        thead th {
            background-color: #212529 !important;
            color: #fff !important;
            font-weight: 700;
        }

        tbody tr {
            page-break-inside: avoid;
        }

        .nama-alternatif {
            text-align: left;
            white-space: nowrap;
        }

        /* BAGIAN TABEL */

        .table-section {
            margin-bottom: 18px;
            page-break-inside: auto;
        }

        /* TOMBOL */

        .print-button {
            margin-bottom: 18px;
        }

        /* 
       TANDA TANGAN*/

        .signature {
            width: 240px;
            margin-left: auto;
            margin-top: 35px;
            text-align: center;
            line-height: 1.4;
            font-size: 10px;
        }

        .signature-space {
            height: 65px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
        }

        /* PRINT / PDF */

        @media print {

            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            html,
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            body {
                font-size: 10px;
            }

            .no-print {
                display: none !important;
                visibility: hidden !important;
            }

            .header {
                margin-bottom: 16px;
            }

            .header h3,
            .header h4 {
                font-size: 16px;
            }

            .header p {
                font-size: 10px;
            }

            .info {
                font-size: 10px;
                margin-bottom: 14px;
            }

            .section-title {
                font-size: 12px;
                margin-bottom: 6px;
            }

            th,
            td {
                padding: 5px 5px !important;
                font-size: 9.5px;
            }

            .table-section {
                margin-bottom: 16px;
            }

            .signature {
                margin-top: 28px;
                font-size: 10px;
            }

            .signature-space {
                height: 60px;
            }
        }

        /* TAMPILAN MOBILE */

        @media screen and (max-width: 768px) {

            body {
                padding: 20px 16px;
                font-size: 12px;
            }

            .container-fluid {
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .header {
                margin-bottom: 20px;
            }

            .info {
                margin-bottom: 18px;
                font-size: 11px;
                line-height: 1.6;
            }

            .print-button {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 20px;
            }

            .print-button .btn {
                font-size: 12px;
                padding: 8px 14px;
            }

            .table-section {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                margin-bottom: 25px;
            }

            table {
                width: max-content;
                min-width: 900px;
                table-layout: auto;
            }

            th,
            td {
                padding: 7px 9px !important;
                font-size: 11px;
                white-space: nowrap;
            }

            .nama-alternatif {
                min-width: 150px;
            }

            .section-title {
                font-size: 13px;
                margin-bottom: 8px;
            }

            .signature {
                width: 240px;
                margin-top: 35px;
                font-size: 11px;
            }
        }

        .qr-code {
            margin: 10px auto 8px;
            text-align: center;
        }

        .qr-code img {
            width: 85px;
            height: 85px;
            display: block;
            margin: 0 auto;
        }
    </style>

</head>

<body>
    @php
    $bulanRomawi = [
    1 => 'I',
    2 => 'II',
    3 => 'III',
    4 => 'IV',
    5 => 'V',
    6 => 'VI',
    7 => 'VII',
    8 => 'VIII',
    9 => 'IX',
    10 => 'X',
    11 => 'XI',
    12 => 'XII'
    ];

    $nomorUrut = str_pad($kelompok->id, 3, '0', STR_PAD_LEFT);

    $nomorSurat = $nomorUrut
    . '/BLT-DD/DSB/'
    . $bulanRomawi[date('n')]
    . '/'
    . date('Y');
    @endphp

    <div class="container-fluid">

        <!-- HEADER -->

        <!-- KOP SURAT -->

        <div class="kop-surat">

            <div class="kop-wrapper">

                <!-- LOGO -->

                <div class="kop-logo">

                    @if(!empty($isPdf))
                    <img src="{{ public_path('images/Logo.jpeg') }}"
                        alt="Logo Desa Sei Bamban">
                    @else
                    <img src="{{ asset('images/Logo.jpeg') }}"
                        alt="Logo Desa Sei Bamban">
                    @endif

                </div>


                <!-- TEKS KOP -->

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
                        Alamat : Jl. Besar Batang Serangan, Desa Sei Bamban,
                        Kec. Batang Serangan Kode Pos 20883
                    </div>

                </div>

            </div>

            <div class="garis-kop-1"></div>

            <div class="garis-kop-2"></div>

        </div>


        <!-- JUDUL -->

        <div class="header">

            <h3>
                DATA PERHITUNGAN SMART
            </h3>

            <p>
                Alternatif Penerima Bantuan Langsung Tunai Dana Desa (BLT-DD)
            </p>

        </div>


        <!-- NOMOR SURAT -->
        <div class="nomor-surat">
            <strong>Nomor Surat :</strong>
            {{ $nomorSurat }}
        </div>

        <!-- INFORMASI -->

        <div class="info">

            <div>
                <strong>Dusun</strong>
                : {{ $kelompok->dusun }}
            </div>

            <div>
                <strong>Tanggal</strong>
                : {{ $kelompok->tanggal }}
            </div>

        </div>


        <!-- BUTTON PRINT -->

        @if(empty($isPdf))

{{--        <div class="print-button no-print d-flex gap-2">

            <button onclick="window.print()" class="btn btn-danger">
                <i class="bi bi-printer"></i>
                Cetak
            </button>  </div>
--}}
            <div class="print-button no-print d-flex gap-2">

            <a href="{{ route('smart.download', $kelompok->id) }}"
                class="btn btn-success">
                <i class="bi bi-file-earmark-pdf"></i>
                Download PDF
            </a>

            </div>

       

        @endif

        <!-- TABEL PENILAIAN -->

        <div class="table-section">

            <div class="section-title">
                1. Tabel Penilaian Alternatif
            </div>

            <table>

                <thead>

                    <tr>

                        <th style="width: 60px;">
                            No.
                        </th>

                        <th>
                            Nama Alternatif
                        </th>

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

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td class="nama-alternatif">
                            {{ $a->nama }}
                        </td>

                        @foreach($kriterias as $k)

                        <td>

                            {{
                                        number_format(
                                            $a->penilaians
                                                ->where('kriteria_id', $k->id)
                                                ->first()
                                                ?->nilai ?? 0,
                                            0
                                        )
                                    }}

                        </td>

                        @endforeach

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- HASIL RANKING -->

        <div class="table-section">

            <div class="section-title">
                2. Hasil Perankingan SMART
            </div>

            <table>

                <thead>

                    <tr>

                        <th style="width: 90px;">
                            Ranking
                        </th>

                        <th>
                            Alternatif
                        </th>

                        <th style="width: 160px;">
                            Total Nilai
                        </th>

                        <th style="width: 180px;">
                            Status
                        </th>

                        <th style="width: 180px;">
                            Tanggal Penetapan
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($hasil as $item)

                    <tr>

                        <td>
                            {{ $item->ranking }}
                        </td>

                        <td class="nama-alternatif">
                            {{ $item->alternatif->nama }}
                        </td>

                        <td>
                            {{ number_format($item->nilai, 4, '.', '') }}
                        </td>

                        <td>
                            {{ $item->status ?? 'Direkomendasikan' }}
                        </td>

                        <td>
                            @if($item->status === 'Ditetapkan' && $item->tanggal_penetapan)
                            {{ \Carbon\Carbon::parse($item->tanggal_penetapan)->format('d-m-Y H:i') }}
                            @else
                            -
                            @endif
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- TANDA TANGAN -->

        <div class="signature">

            <div>
                Sei Bamban, {{ date('d-m-Y') }}
            </div>

            <div>
                Disahkan oleh,
            </div>



            <div class="qr-code">
                <img
                    src="data:image/svg+xml;base64,{{ $qrCode }}"
                    alt="QR Code Verifikasi">
            </div>

            <p class="signature-name">
                Rudi Ariyanto
            </p>

            <div>
                Kepala Desa Sei Bamban
            </div>

        </div>

    </div>

</body>

</html>