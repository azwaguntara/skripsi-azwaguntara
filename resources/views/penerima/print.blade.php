<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Daftar Penerima Bantuan - BLT-DD Desa Sei Bamban</title>

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

        .garis-kop-1 {
            border-top: 2px solid #000;
            margin-top: 8px;
        }

        .garis-kop-2 {
            border-top: 5px solid #000;
            margin-top: 3px;
        }

        /* =========================
           JUDUL
        ========================= */

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

        /* =========================
           NOMOR SURAT
        ========================= */

        .nomor-surat {
            text-align: center;
            font-size: 11px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* =========================
           INFORMASI
        ========================= */

        .info {
            margin-bottom: 16px;
            font-size: 11px;
            line-height: 1.5;
        }

        /* =========================
           JUDUL SECTION
        ========================= */

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
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
            line-height: 1.25;
        }

        thead {
            display: table-header-group;
        }

        thead th {
            background-color: #212529;
            color: #fff;
            font-weight: 700;
        }

        tbody tr {
            page-break-inside: avoid;
        }

        .nama-alternatif {
            text-align: left;
        }

        /* =========================
           TANDA TANGAN & QR
        ========================= */

        .footer {
            width: 100%;
            margin-top: 30px;
            display: table;
        }

        .qr-area {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: left;
        }

        .qr-area img {
            width: 85px;
            height: 85px;
            display: block;
        }

        .qr-text {
            font-size: 9px;
            margin-top: 4px;
        }

        .footer-spacer {
            display: table-cell;
            width: 70%;
        }

        .signature {
            display: table-cell;
            width: 30%;
            vertical-align: top;
            text-align: center;
            line-height: 1.4;
            font-size: 10px;
        }

        .signature-space {
            height: 60px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
        }

        /* =========================
           BROWSER
        ========================= */

        .no-print {
            margin-bottom: 18px;
        }

        .no-print button {
            padding: 8px 15px;
            border: none;
            background: #dc3545;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

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

            .no-print {
                display: none !important;
            }

            body {
                font-size: 10px;
            }

            th,
            td {
                padding: 5px !important;
                font-size: 9.5px;
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

    {{-- =========================
         NOMOR SURAT
    ========================= --}}

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

    $nomorUrut = $kelompok
    ? str_pad($kelompok->id, 3, '0', STR_PAD_LEFT)
    : '000';

    $nomorSurat =
    $nomorUrut
    . '/BLT-DD/DSB/'
    . $bulanRomawi[date('n')]
    . '/'
    . date('Y');

    @endphp


    {{-- =========================
         KOP SURAT
    ========================= --}}

    <div class="kop-surat">

        <div class="kop-wrapper">

            <div class="kop-logo">
                @if($logoBase64)
                <img src="data:image/jpeg;base64,{{ $logoBase64 }}"
                    alt="Logo Desa Sei Bamban">
                @endif
            </div>


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


    {{-- =========================
         JUDUL
    ========================= --}}

    <div class="header">

        <h3>
            DAFTAR PENERIMA BANTUAN
        </h3>

        <p>
            Penerima Bantuan Langsung Tunai Dana Desa (BLT-DD)
        </p>

    </div>


    {{-- =========================
         NOMOR
    ========================= --}}

    <div class="nomor-surat">

        <strong>Nomor Surat :</strong>
        {{ $nomorSurat }}

    </div>


    {{-- =========================
         INFORMASI
    ========================= --}}

    <div class="info">

        <div>
            <strong>Dusun</strong>
            :
            {{ $kelompok ? $kelompok->dusun : 'Semua Dusun' }}
        </div>

        <div>
            <strong>Tanggal</strong>
            :
            {{ now()->format('d-m-Y') }}
        </div>

    </div>


    {{-- =========================
         TABEL PENERIMA
    ========================= --}}

    <div>

        <table>

            <thead>

                <tr>

                    <th style="width: 45px;">
                        No
                    </th>

                    <th style="width: 170px;">
                        Nama Penerima
                    </th>

                    <th style="width: 130px;">
                        Dusun
                    </th>

                    <th>
                        Ranking SMART
                    </th>

                    <th>
                        Nilai SMART
                    </th>

                    <th>
                        Ranking COPRAS
                    </th>

                    <th>
                        Nilai COPRAS
                    </th>

                    <th>
                        Metode Penetapan
                    </th>

                    <th>
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($penerima as $item)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td class="nama-alternatif">
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
                        {{ $item['metode'] }}
                    </td>

                    <td>
                        <strong>
                            Ditetapkan
                        </strong>
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="9">
                        Belum ada penerima bantuan yang ditetapkan.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =========================
     QR + PENGESAHAN
========================= --}}

    <div class="footer">

        {{-- SPASI KIRI --}}
        <div class="footer-spacer"></div>

        {{-- TANDA TANGAN --}}
        <div class="signature">

            <div>Sei Bamban, {{ date('d-m-Y') }}</div>
            <div>Disahkan oleh,</div>

            <div class="qr-code">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}"
                    alt="QR Code Verifikasi">
            </div>

            <p class="signature-name">Rudi Ariyanto</p>
            <div>Kepala Desa Sei Bamban</div>

        </div>

    </div>

</body>

</html>