<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Sistem Penentuan Penerima BLT-DD
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding: 30px;
            font-size: 14px;
            background: white;
        }

        h3 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .judul {
            margin-bottom: 30px;
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

        .table-dark {
            background: black !important;
            color: white !important;
        }

        @media print {

            @page {
                size: landscape;
                margin: 10mm;
            }

            .no-print {
                display: none;
            }

            body {
                zoom: 90%;
            }

        }
    </style>

</head>

<body>

    <div class="container-fluid">

        <!-- JUDUL -->

        <div class="judul">

            <h3 class="text-center fw-bold">
                Data Perhitungan SMART Alternatif Penerima <br>
                Bantuan Langsung Tunai Dana Desa <br>
                (BLT-DD) Desa Sei Bamban
            </h3>

            <div>
                Dusun :
                <b>{{ $kelompok->dusun }}</b>
            </div>

            <div>
                Tanggal :
                {{ $kelompok->tanggal }}
            </div>

        </div>

        <!-- BUTTON -->

        <div class="mb-4 no-print">

            <button onclick="window.print()" class="btn btn-danger">

                <i class="bi bi-printer"></i>
                Print

            </button>

        </div>

        <!-- TABEL -->

        <h5 class="fw-bold mb-3">
            Tabel Penilaian
        </h5>

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>

                    <th>No</th>

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

                        <td>
                            {{ $a->nama }}
                        </td>

                        @foreach($kriterias as $k)

                                    <td>

                                        {{
                            $a->penilaians
                                ->where('kriteria_id', $k->id)
                                ->first()
                                    ?->nilai ?? 0
                                                                                    }}

                                    </td>

                        @endforeach

                    </tr>

                @endforeach

            </tbody>

        </table>

        <h4 class="mt-5 mb-3">
            Hasil Ranking SMART
        </h4>

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>
                    <th>Ranking</th>
                    <th>Alternatif</th>
                    <th>Total Nilai</th>
                </tr>

            </thead>

            <tbody>

                @foreach($hasil as $item)

                    <tr>

                        <td>{{ $item->ranking }}</td>

                        <td>{{ $item->alternatif->nama }}</td>

                        <td>{{ number_format($item->nilai, 4) }}</td>

                    </tr>

                @endforeach

            </tbody>


        </table>

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