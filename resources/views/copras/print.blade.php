<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Sistem Penentuan Penerima BLT-DD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding: 30px;
            font-size: 14px;
        }

        table {
            width: 100%;
        }

        th,
        td {
            border: 1px solid black !important;
            padding: 8px !important;
            text-align: center;
            vertical-align: middle;
        }

        @media print {

            @page {
                size: landscape;
                margin: 10mm;
            }

            .no-print {
                display: none;
            }

        }
    </style>

</head>

<body>

        <!-- JUDUL -->


        <h4 class="text-center fw-bold mb-4">

            Data Perhitungan COPRAS
            <br>

            Penerima BLT-DD Desa Sei Bamban

        </h4>

        <div class="mb-4">

            <b>Dusun :</b>
            {{ $kelompok->dusun }}

            <br>

            <b>Tanggal :</b>
            {{ $kelompok->tanggal }}

        </div>

        <div class="mb-4 no-print">

            <button onclick="window.print()" class="btn btn-danger">

                <i class="bi bi-printer"></i>
                Print

            </button>

        </div>

        <!-- TABEL MATRIX -->

        <h5 class="fw-bold mb-3">
            Tabel Penilaian
        </h5>

        <table class="table table-bordered mb-5">

            <thead class="table-dark">

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

                @foreach($alternatifs as $alt)

                    <tr>

                        <td>
                            {{ $alt->nama }}
                        </td>

                        @foreach($kriterias as $k)

                                    <td>

                                        {{
                            $matrix[$alt->id][$k->id]
                                                                                    }}

                                    </td>

                        @endforeach

                    </tr>

                @endforeach

            </tbody>

        </table>

        <!-- TABEL HASIL -->

        <h5 class="fw-bold mb-3">
            Hasil Ranking COPRAS
        </h5>

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>

                    <th>Ranking</th>
                    <th>Alternatif</th>
                    <th>Qi</th>
                    <th>Utility (%)</th>

                </tr>

            </thead>

            <tbody>

                @foreach($ranking as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item['nama'] }}
                        </td>

                        <td>
                            {{ number_format($item['qi'], 4) }}
                        </td>

                        <td>
                            {{ number_format($item['ui'], 2) }}%
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <!-- TTD -->

        <div class="mt-5 text-end">

            <p class="mb-5">

                Sei Bamban,
                {{ date('d-m-Y') }}

                <br>
                Disahkan oleh : <br>

            </p>

            <br><br><br>

            <h6 class="fw-bold text-uppercase
            text-decoration-underline mb-0">

                Rudi Ariyanto


            </h6>
            Kepala Desa Sei Bamban

        </div>

    </div>

    <script>

        window.onload = function () {

            window.print();

        }

    </script>

</body>

</html>