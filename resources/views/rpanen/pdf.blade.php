<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Realisasi Panen</title>
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
        <h1>Laporan Realisasi Panen</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Pekerjaan</th>
                <th>Blok</th>
                <th>Tahun Tanam</th>
                <th>Divisi</th>
                <th>Estate</th>
                <th>Hasil</th>
                <th>Satuan</th>
                <th>Jumlah TK</th>
                <th>Ha Panen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['jenis_kerja'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tt'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['hasil'] }}</td>
                <td>{{ $item['satuan'] }}</td>
                <td>{{ $item['tk'] }}</td>
                <td>{{ $item['ha_panen'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>