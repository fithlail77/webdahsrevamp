<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemakaian BBM</title>
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
        <h1>Laporan Pemakaian BBM</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor</th>
                <th>Kode Material</th>
                <th>Nama</th>
                <th>Unit</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Tanggal Posting</th>
                <th>Lokasi Penyimpanan</th>
                <th>Deskripsi</th>
                <th>Bulan</th>
                <th>Nomor Unit</th>
                <th>Nama Unit</th>
                <th>Kelompok Unit</th>
                <th>Biaya BBM</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['i_no'] }}</td>
                <td>{{ $item['material_code'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['unit'] }}</td>
                <td>{{ $item['i_qty'] }}</td>
                <td>{{ $item['i_date'] }}</td>
                <td>{{ $item['post_date'] }}</td>
                <td>{{ $item['stor_loct'] }}</td>
                <td>{{ $item['desc'] }}</td>
                <td>{{ $item['bulan'] }}</td>
                <td>{{ $item['no_unit'] }}</td>
                <td>{{ $item['nama_unit'] }}</td>
                <td>{{ $item['kelompok_unit'] }}</td>
                <td>{{ $item['biaya_bbm'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>