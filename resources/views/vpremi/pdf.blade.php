<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Premi</title>
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
        <h1>Laporan Premi</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No KAB</th>
                <th>Nama KAB</th>
                <th>NIK</th>
                <th>Nama Karyawan</th>
                <th>Estate</th>
                <th>HM/KM Awal</th>
                <th>HM/KM Akhir</th>
                <th>Total HM/KM</th>
                <th>Lokasi</th>
                <th>Divisi</th>
                <th>Jenis Pekerjaan</th>
                <th>Tarif Satuan</th>
                <th>Hasil 1</th>
                <th>Satuan 1</th>
                <th>Hasil 2</th>
                <th>Satuan 2</th>
                <th>Total Premi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['no_kab'] }}</td>
                <td>{{ $item['nama_kab'] }}</td>
                <td>{{ $item['nik'] }}</td>
                <td>{{ $item['nama_karyawan'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['hmkm_awal'] }}</td>
                <td>{{ $item['hmkm_akhir'] }}</td>
                <td>{{ $item['total_hmkm'] }}</td>
                <td>{{ $item['lokasi'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['jenis_pekerjaan'] }}</td>
                <td>{{ $item['tarif_satuan'] }}</td>
                <td>{{ $item['hasil_1'] }}</td>
                <td>{{ $item['satuan_1'] }}</td>
                <td>{{ $item['hasil_2'] }}</td>
                <td>{{ $item['satuan_2'] }}</td>
                <td>{{ $item['total_premi'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>