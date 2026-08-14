<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Perhitungan SMART - BLT-DD Desa Sei Bamban
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            padding: 30px 40px;
            font-size: 13px;
            color: #000;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .header p {
            margin: 0;
            font-size: 13px;
        }

        .info {
            margin-bottom: 20px;
            font-size: 13px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000 !important;
            padding: 7px 8px !important;
            text-align: center;
            vertical-align: middle;
        }

        thead th {
            background-color: #212529 !important;
            color: #fff !important;
            font-weight: 700;
        }

        .nama-alternatif {
            text-align: left;
            white-space: nowrap;
        }

        .table-section {
            margin-bottom: 30px;
        }

        .print-button {
            margin-bottom: 25px;
        }

        .signature {
            width: 280px;
            margin-left: auto;
            margin-top: 50px;
            text-align: center;
            line-height: 1.5;
        }

        .signature-space {
            height: 80px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        @media print {

            @page {
                size: landscape;
                margin: 10mm;
            }

            body {
                padding: 0;
                font-size: 11px;
            }

            .no-print {
                display: none !important;
            }

            .header h3 {
                font-size: 16px;
            }

            .header p,
            .info {
                font-size: 11px;
            }

            .section-title {
                font-size: 13px;
            }

            th,
            td {
                padding: 5px 6px !important;
            }

            .table-section {
                margin-bottom: 20px;
            }

            .signature {
                margin-top: 30px;
                font-size: 11px;
            }

            .signature-space {
                height: 60px;
            }

        }
    </style>

</head>

<body>

    <div class="container-fluid">

        <!-- HEADER -->

        <div class="header">

            <h3>
                DATA PERHITUNGAN SMART
            </h3>

            <p>
                Alternatif Penerima Bantuan Langsung Tunai Dana Desa (BLT-DD)
            </p>

            <p>
                Desa Sei Bamban
            </p>

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

        <div class="print-button no-print">

            <button onclick="window.print()" class="btn btn-danger">

                <i class="bi bi-printer"></i>
                Cetak

            </button>

        </div>


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

                        <th style="width: 180px;">
                            Total Nilai
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

            <div>
                Kepala Desa Sei Bamban
            </div>

            <div class="signature-space"></div>

            <p class="signature-name">
                Rudi Ariyanto
            </p>

            <div>
                Kepala Desa Sei Bamban
            </div>

        </div>

    </div>


    <script>
        window.onload = function() {

            window.print();

        };
    </script>

</body>

</html>