<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Contract CPO</title>
    <style>
        @page {
            size: A4 landscape;
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
        <h1>Laporan Contract CPO</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>GGU SC</th>
                <th>GUM SC</th>
                <th>Tanggal Rencana Loading</th>
                <th>Tanggal Real Loading</th>
                <th>Tanggal BA Loading</th>
                <th>Tanggal Pricing</th>
                <th>Harga Real</th>
                <th>Nilai Penjualan</th>
                <th>Kuantiti Kontrak (Ton)</th>
                <th>Kuantiti Real (Kg)</th>
                <th>Armada</th>
                <th>Suhu</th>
                <th>Buyer</th>
                <th>Lama Hari Loading</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['ggu_sc'] }}</td>
                <td>{{ $item['gum_sc'] }}</td>
                <td>{{ $item['plan_loading_tk'] }}</td>
                <td>{{ $item['real_loading_tk'] }}</td>
                <td>{{ $item['tgl_ba_loading_tk'] }}</td>
                <td>{{ $item['tgl_pricing'] }}</td>
                <td>{{ $item['real_price'] }}</td>
                <td>{{ $item['nilai_penjualan'] }}</td>
                <td>{{ $item['kontrak_qty_ton'] }}</td>
                <td>{{ $item['real_qty_kg'] }}</td>
                <td>{{ $item['kapal_tongkang'] }}</td>
                <td>{{ $item['suhu'] }}</td>
                <td>{{ $item['buyer'] }}</td>
                <td>{{ $item['lama_loading_hari'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>