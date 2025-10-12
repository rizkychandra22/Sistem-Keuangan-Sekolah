<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran</title>
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
    <h3>Laporan Pengeluaran Keuangan Sekolah</h3>
    <p style="text-align: center;">
        Tanggal {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} Hingga {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
    </p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kebutuhan</th>
                <th>Keterangan</th>
                <th width="65">Tanggal</th>
                <th>Sumber</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluarans as $index => $pengeluaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pengeluaran->kebutuhan }}</td>
                    <td>{{ $pengeluaran->keterangan }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $pengeluaran->sumber }}</td>
                    <td>Rp{{ number_format($pengeluaran->jumlah, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <th colspan="5">Total Pengeluaran:</th>
                <td>Rp{{ number_format($totalPengeluaran, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Total Pengeluaran Berdasarkan Kategori Kebutuhan</h4>
    <table>
        <thead>
            <tr>
                <th width="5">No</th>
                <th>Kebutuhan</th>
                <th>Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kebutuhanBulanIni as $index => $total)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $total->kebutuhan }}</td>
                    <td>Rp{{ number_format($total->total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <th colspan="2">Total Pengeluaran</th>
                <td>Rp{{ number_format($totalPengeluaran, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Total Pengeluaran Berdasarkan Kategori Sumber</h4>
    <table>
        <thead>
            <tr>
                <th width="5">No</th>
                <th>Sumber</th>
                <th>Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sumberkeluarBulanIni as $index => $total)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $total->sumber }}</td>
                    <td>Rp{{ number_format($total->total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <th colspan="2">Total Pengeluaran</th>
                <td>Rp{{ number_format($totalPengeluaran, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
