<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
        .summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN BARANG</h1>
        <p>J-Track - Sistem Manajemen Stok dan Penjualan</p>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 20%">Kategori</th>
                <th style="width: 30%">Nama Barang</th>
                <th style="width: 15%" class="text-right">Total Jumlah</th>
                <th style="width: 30%" class="text-right">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->barang->kategori ?? '-' }}</td>
                <td>{{ $row->barang->nama ?? '-' }}</td>
                <td class="text-right">{{ $row->total_jumlah }}</td>
                <td class="text-right">Rp {{ number_format($row->total_penjualan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">
            <strong>Total Jumlah:</strong>
            <strong>{{ number_format($totalJumlah, 0, ',', '.') }} unit</strong>
        </div>
        <div class="summary-row">
            <strong>Total Omset:</strong>
            <strong>Rp {{ number_format($totalOmset, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

