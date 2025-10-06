<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Areal Statement</title>
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
        <h1>Laporan Areal Statement</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Estate</th>
                <th>Divisi</th>
                <th>Blok</th>
                <th>Tahun Tanam</th>
                <th>Status Tanaman</th>
                <th>Status Lahan</th>
                <th>Jenis Bibit</th>
                <th>Topografi</th>
                <th>Jenis Tanah</th>
                <th>Pokok</th>
                <th>Luas (Ha)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['bulan'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tahun_tanam'] }}</td>
                <td>{{ $item['status_tanaman'] }}</td>
                <td>{{ $item['status_lahan'] }}</td>
                <td>{{ $item['jenis_bibit'] }}</td>
                <td>{{ $item['topografi'] }}</td>
                <td>{{ $item['jenis_tanah'] }}</td>
                <td>{{ $item['pokok'] }}</td>
                <td>{{ $item['luas'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>