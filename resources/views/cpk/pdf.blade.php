<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Contract CPO</title>
    <style>
        @page {
            size: A3 landscape;
        }
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Contract Kernel</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>LTC</th>
                <th>Nomor SC</th>
                <th>Bulan</th>
                <th>Tanggal Pricing</th>
                <th>Harga</th>
                <th>Diskon GGU</th>
                <th>Harga Real</th>
                <th>Tanggal DP</th>
                <th>Rencana Awal Kirim</th>
                <th>Rencana Closed Kirim</th>
                <th>Actual Awal Kirim</th>
                <th>Actual Akhir Kirim</th>
                <th>Quntiti Kontrak (Kg)</th>
                <th>Pembeli</th>
                <th>Status</th>
                <th>Real Qty (Kg)</th>
                <th>Buyer Received Qty (Kg)</th>
                <th>Rp</th>
                <th>Keterangan</th>
                <th>Periode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['ltc'] }}</td>
                <td>{{ $item['nomor_sc'] }}</td>
                <td>{{ $item['bln_name'] }}</td>
                <td>{{ $item['date_pricing'] }}</td>
                <td>{{ $item['price'] }}</td>
                <td>{{ $item['dicount_ggu'] }}</td>
                <td>{{ $item['real_price'] }}</td>
                <td>{{ $item['dp_date'] }}</td>
                <td>{{ $item['rencana_awal_kirim'] }}</td>
                <td>{{ $item['rencana_closed_kirim'] }}</td>
                <td>{{ $item['actual_awal_kirim'] }}</td>
                <td>{{ $item['actual_closed_kirim'] }}</td>
                <td>{{ $item['qty_kontrak_kg'] }}</td>
                <td>{{ $item['buyer'] }}</td>
                <td>{{ $item['status'] }}</td>
                <td>{{ $item['real_qty_kg'] }}</td>
                <td>{{ $item['buyer_received_qty_kg'] }}</td>
                <td>{{ $item['rp'] }}</td>
                <td>{{ $item['keterangan'] }}</td>
                <td>{{ $item['bulan'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>