<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perawatan Kebun</title>
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
        <h1>Laporan Perawatan Kebun</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Perawatan</th>
                <th>Blok</th>
                <th>Tahun Tanam</th>
                <th>Divisi</th>
                <th>Estate</th>
                <th>Lahan</th>
                <th>Hasil</th>
                <th>Satuan</th>
                <th>Jumlah Tenaga</th>
                <th>Material 1</th>
                <th>Jumlah 1</th>
                <th>Satuan 1</th>
                <th>Material 2</th>
                <th>Jumlah 2</th>
                <th>Satuan 2</th>
                <th>Material 3</th>
                <th>Jumlah 3</th>
                <th>Satuan 3</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['jenis_perawatan'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tahun_tanam'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['lahan'] }}</td>
                <td>{{ $item['hasil'] }}</td>
                <td>{{ $item['satuan'] }}</td>
                <td>{{ $item['jml_tenaga'] }}</td>
                <td>{{ $item['material_1'] }}</td>
                <td>{{ $item['jumlah_1'] }}</td>
                <td>{{ $item['satuan_1'] }}</td>
                <td>{{ $item['material_2'] }}</td>
                <td>{{ $item['jumlah_2'] }}</td>
                <td>{{ $item['satuan_2'] }}</td>
                <td>{{ $item['material_3'] }}</td>
                <td>{{ $item['jumlah_3'] }}</td>
                <td>{{ $item['satuan_3'] }}</td>
                <td>{{ $item['keterangan'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>