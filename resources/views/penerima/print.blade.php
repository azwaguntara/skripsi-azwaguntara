<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Daftar Penerima Bantuan</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .judul {
            text-align: center;
            margin-bottom: 5px;
        }

        .judul h2 {
            margin: 0;
            font-size: 18px;
        }

        .judul p {
            margin: 4px 0 15px;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 7px;
            text-align: center;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .ttd {
            width: 250px;
            margin-left: auto;
            margin-top: 40px;
            text-align: center;
        }

        .spasi {
            height: 70px;
        }

        .no-print {
            margin-bottom: 15px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- Tombol hanya muncul saat halaman Cetak, tidak muncul di PDF --}}
    <div class="no-print">
        <button onclick="window.print()">
            🖨 Cetak
        </button>
    </div>

    <div class="judul">

        <h2>DAFTAR PENERIMA BANTUAN</h2>

        <p>
            Desa Sei Bamban

            @if($kelompok)
            <br>
            Dusun: {{ $kelompok->dusun }}
            @else
            <br>
            Semua Dusun
            @endif
        </p>

    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penerima</th>
                <th>Dusun</th>
                <th>Ranking SMART</th>
                <th>Nilai SMART</th>
                <th>Ranking COPRAS</th>
                <th>Nilai COPRAS</th>
                <th>Metode Penetapan</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($penerima as $item)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td class="text-left">
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
                    Ditetapkan
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

    <div class="ttd">

        Sei Bamban,
        {{ now()->translatedFormat('d F Y') }}

        <br><br>

        Kepala Desa Sei Bamban

        <div class="spasi"></div>

        <strong>
            ______________________________
        </strong>

    </div>

</body>

</html>