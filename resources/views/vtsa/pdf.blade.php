<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Monitoring Tankos Solid Abu Boiler</title>
    <style>
        @page {
            size: A4 landscape;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
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
            padding: 4px;
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
        <h1>Laporan Monitoring Tankos Solid Abu Boiler</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Tiket</th>
                <th>Transportir</th>
                <th>Sopir</th>
                <th>No Polisi</th>
                <th>Material</th>
                <th>Satuan</th>
                <th>Blok</th>
                <th>Tahun Tanam</th>
                <th>Estate</th>
                <th>Divisi</th>
                <th>Lahan</th>
                <th>Bruto</th>
                <th>Tarra</th>
                <th>Netto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['no_ticket'] }}</td>
                <td>{{ $item['transportir'] }}</td>
                <td>{{ $item['supir'] }}</td>
                <td>{{ $item['nopol'] }}</td>
                <td>{{ $item['material'] }}</td>
                <td>{{ $item['satuan'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tt'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['lahan'] }}</td>
                <td>{{ $item['bruto'] }}</td>
                <td>{{ $item['tara'] }}</td>
                <td>{{ $item['netto'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>