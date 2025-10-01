<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Monitoring Aramco</title>
    <style>
        @page {
            size: A3 landscape;
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
        <h1>Laporan Monitoring Pemasangan Aramco</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Perakitan</th>
                <th>Tanggal Pasang</th>
                <th>No PO</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Lokasi</th>
                <th>Estate</th>
                <th>Divisi</th>
                <th>Titik Kordinat</th>
                <th>Tahun Tanam</th>
                <th>Lahan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal_rakit'] }}</td>
                <td>{{ $item['tanggal_pasang'] }}</td>
                <td>{{ $item['no_po'] }}</td>
                <td>{{ $item['ukuran'] }}</td>
                <td>{{ $item['jumlah'] }}</td>
                <td>{{ $item['satuan'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['kordinat'] }}</td>
                <td>{{ $item['tahun_tanam'] }}</td>
                <td>{{ $item['lahan'] }}</td>
                <td>{{ $item['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>