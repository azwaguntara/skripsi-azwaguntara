<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Penerima Bantuan - Desa Sei Bamban</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f5f6f8;
            font-family: Arial, Helvetica, sans-serif;
        }

        .verification-card {
            max-width: 1000px;
            margin: 40px auto;
        }

        .kop {
            display: table;
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .kop-logo {
            display: table-cell;
            width: 130px;
            vertical-align: middle;
            text-align: left;
        }

        .kop-logo img {
            width: 90px;
            height: auto;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding-right: 90px;
            font-family: "Times New Roman", serif;
        }

        .kop-text .pemerintah {
            font-size: 24px;
            font-weight: bold;
            line-height: 1.1;
        }

        .kop-text .kecamatan {
            font-size: 25px;
            font-weight: bold;
            line-height: 1.1;
        }

        .kop-text .desa {
            font-size: 34px;
            font-weight: bold;
            line-height: 1.05;
            margin-top: 3px;
        }

        .kop-text .alamat {
            font-size: 13px;
            margin-top: 6px;
        }

        .status-valid {
            background: #198754;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            display: inline-block;
            font-weight: bold;
        }

        table th {
            background: #212529 !important;
            color: white !important;
        }

        .footer-verifikasi {
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            margin-top: 25px;
        }

        /* =========================
   RESPONSIVE
========================= */

        @media (max-width: 768px) {

            .verification-card {
                margin: 15px auto;
            }

            .card-body {
                padding: 20px !important;
            }

            /* KOP */
            .kop {
                display: block;
                text-align: center;
                padding-bottom: 12px;
            }

            .kop-logo {
                display: block;
                width: 100%;
                text-align: center;
                margin-bottom: 10px;
            }

            .kop-logo img {
                width: 70px;
            }

            .kop-text {
                display: block;
                width: 100%;
                padding-right: 0;
            }

            .kop-text .pemerintah {
                font-size: 18px;
            }

            .kop-text .kecamatan {
                font-size: 19px;
            }

            .kop-text .desa {
                font-size: 26px;
            }

            .kop-text .alamat {
                font-size: 11px;
                line-height: 1.4;
            }

            /* JUDUL */
            .text-center h4 {
                font-size: 20px;
            }

            .status-valid {
                font-size: 12px;
                padding: 8px 14px;
            }

            /* INFORMASI */
            .row.mb-4 .col-md-6 {
                width: 100%;
            }

            .row.mb-4 table {
                font-size: 13px;
                width: 100%;
            }

            .row.mb-4 table td {
                padding: 4px 0;
            }

            /* TABEL */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive table {
                min-width: 900px;
            }

            .table-responsive th,
            .table-responsive td {
                font-size: 11px;
                white-space: nowrap;
                padding: 7px 8px;
            }

            /* ALERT */
            .alert {
                font-size: 12px;
                line-height: 1.5;
            }

            /* FOOTER */
            .footer-verifikasi {
                font-size: 11px;
                line-height: 1.5;
            }
        }


        /* HP kecil */
        @media (max-width: 480px) {

            .verification-card {
                margin: 8px auto;
            }

            .card-body {
                padding: 15px !important;
            }

            .container {
                padding-left: 8px;
                padding-right: 8px;
            }

            .kop-logo img {
                width: 60px;
            }

            .kop-text .pemerintah {
                font-size: 16px;
            }

            .kop-text .kecamatan {
                font-size: 17px;
            }

            .kop-text .desa {
                font-size: 23px;
            }

            .kop-text .alamat {
                font-size: 10px;
            }

            .text-center h4 {
                font-size: 18px;
            }

            .status-valid {
                font-size: 11px;
                padding: 7px 12px;
            }

            .section-title {
                font-size: 16px;
            }

            .alert {
                padding: 12px;
            }

            .footer-verifikasi {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card shadow-sm verification-card">

            <div class="card-body p-4">

                {{-- KOP --}}
                <div class="kop">

                    <div class="kop-logo">
                        <img
                            src="{{ asset('images/Logo.jpeg') }}"
                            alt="Logo Desa Sei Bamban">
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


                {{-- JUDUL --}}

                <div class="text-center mb-4">

                    <h4 class="fw-bold">
                        VERIFIKASI DOKUMEN
                    </h4>

                    <div class="status-valid">
                        ✓ DOKUMEN TERVERIFIKASI
                    </div>

                </div>


                {{-- INFORMASI --}}

                <div class="row mb-4">

                    <div class="col-md-6">

                        <table class="table table-borderless">

                            <tr>
                                <td width="150">
                                    <strong>Dusun</strong>
                                </td>

                                <td>
                                    : {{ $kelompok ? $kelompok->dusun : 'Semua Dusun' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Tanggal Verifikasi</strong>
                                </td>

                                <td>
                                    : {{ now()->format('d-m-Y H:i') }}
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>


                {{-- DATA PENERIMA --}}

                <h5 class="fw-bold mb-3">
                    Daftar Penerima Bantuan
                </h5>

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead>

                            <tr>

                                <th width="50">
                                    No
                                </th>

                                <th>
                                    Nama Penerima
                                </th>

                                <th>
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
                                    Metode
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($penerima as $item)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $item['nama'] }}
                                </td>

                                <td>
                                    {{ $item['dusun'] }}
                                </td>

                                <td class="text-center">
                                    {{ $item['ranking_smart'] ?? '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $item['nilai_smart'] !== null
                                    ? number_format($item['nilai_smart'], 4)
                                    : '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $item['ranking_copras'] ?? '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $item['nilai_copras'] !== null
                                    ? number_format($item['nilai_copras'], 4)
                                    : '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $item['metode'] }}
                                </td>

                                <td class="text-center">

                                    <span class="badge bg-success">
                                        Ditetapkan
                                    </span>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center">

                                    Data penerima tidak ditemukan.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- INFORMASI VALIDASI --}}

                <div class="alert alert-success mt-4">

                    <strong>Dokumen Valid.</strong>

                    <br>

                    Data penerima bantuan pada halaman ini
                    merupakan data yang telah ditetapkan
                    melalui sistem pendukung keputusan
                    Desa Sei Bamban.

                </div>


                <div class="footer-verifikasi">

                    <div>
                        Sistem Pendukung Keputusan
                        Penentuan Penerima Bantuan Sosial
                        Desa Sei Bamban
                    </div>

                    <div>
                        Dokumen ini diverifikasi secara elektronik
                        melalui QR Code.
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>