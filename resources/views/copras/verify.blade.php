<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Dokumen COPRAS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="card shadow border-0">

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <h3 class="text-success fw-bold">
                        ✓ DOKUMEN VALID
                    </h3>

                    <p class="text-muted">
                        Dokumen telah terverifikasi oleh Sistem
                        Pendukung Keputusan Desa Sei Bamban
                    </p>

                </div>

                <hr>

                <table class="table">

                    <tr>
                        <th width="35%">Metode</th>

                        <td>COPRAS</td>
                    </tr>

                    <tr>
                        <th>Dusun</th>

                        <td>
                            {{ $kelompok->dusun }}
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>

                        <td>
                            <span class="badge bg-success">
                                Valid
                            </span>
                        </td>
                    </tr>

                </table>

                <h5 class="mt-4">
                    Hasil Perankingan COPRAS
                </h5>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-dark">

                            <tr>
                                <th>Ranking</th>
                                <th>Nama Alternatif</th>
                                <th>Nilai Qi</th>
                                <th>Nilai Ui (%)</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($ranking as $item)

                            <tr>

                                <td>
                                    {{ $item['ranking'] }}
                                </td>

                                <td>
                                    {{ $item['nama'] }}
                                </td>

                                <td>
                                    {{ number_format(
                                            $item['qi'],
                                            4,
                                            '.',
                                            ''
                                        ) }}
                                </td>

                                <td>
                                    {{ number_format(
                                            $item['ui'],
                                            2,
                                            '.',
                                            ''
                                        ) }}%
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>