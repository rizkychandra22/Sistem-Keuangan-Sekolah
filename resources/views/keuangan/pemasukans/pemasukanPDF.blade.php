<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Pemasukan</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            h3, h4 {
                text-align: center;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .total-row th, .total-row td {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <h3>Laporan Pemasukan Keuangan Sekolah</h3>
        <p style="text-align: center;">
            Tanggal {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} Hingga {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
        </p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Sumber</th>
                    <th>Keterangan</th>
                    <th width="65">Tanggal</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemasukans as $index => $pemasukan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pemasukan->sumber }}</td>
                        <td>{{ $pemasukan->keterangan }}</td>
                        <td>{{ \Carbon\Carbon::parse($pemasukan->tanggal)->format('d-m-Y') }}</td>
                        <td>Rp{{ number_format($pemasukan->jumlah, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <th colspan="4">Total Pemasukan:</th>
                    <td>Rp{{ number_format($totalPemasukan, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <h4>Total Pemasukan Berdasarkan Kategori Sumber</h4>
        <table>
            <thead>
                <tr>
                    <th width="5">No</th>
                    <th>Sumber</th>
                    <th>Total Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sumbermasukBulanIni as $index => $total)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $total->sumber }}</td>
                        <td>Rp{{ number_format($total->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <th colspan="2">Total Pemasukan</th>
                    <td>Rp{{ number_format($totalPemasukan, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        {{-- <script type="text/javascript">
            window.onload = function() {
                window.print();
            };
        </script> --}}
    </body>
</html>
