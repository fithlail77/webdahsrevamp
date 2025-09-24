<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SPTBS</title>
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
        <h1>Laporan SPTBS</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Angkutan</th>
                <th>No Tiket</th>
                <th>Tanggal Tiket</th>
                <th>No SPTBS</th>
                <th>Tanggal SPTBS</th>
                <th>Tanggal Panen</th>
                <th>Nama Supir</th>
                <th>No Polisi</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Estate</th>
                <th>Divisi</th>
                <th>Blok</th>
                <th>Tahun Tanam</th>
                <th>Jenis Lahan</th>
                <th>Jumlah Tandan</th>
                <th>Berondolan</th>
                <th>Berat Bruto</th>
                <th>Berat Tarra</th>
                <th>Berat Netto</th>
                <th>Jumlah Grading</th>
                <th>Berat Bersih</th>
                <th>BJR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['angkutan'] }}</td>
                <td>{{ $item['no_tiket'] }}</td>
                <td>{{ $item['tanggal_tiket'] }}</td>
                <td>{{ $item['no_sptbs'] }}</td>
                <td>{{ $item['tanggal_sptbs'] }}</td>
                <td>{{ $item['tanggal_panen'] }}</td>
                <td>{{ $item['nama_supir'] }}</td>
                <td>{{ $item['no_polisi'] }}</td>
                <td>{{ $item['jam_masuk'] }}</td>
                <td>{{ $item['jam_keluar'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tahun_tanam'] }}</td>
                <td>{{ $item['lahan'] }}</td>
                <td>{{ $item['jumlah_tandan'] }}</td>
                <td>{{ $item['berondolan'] }}</td>
                <td>{{ $item['berat_bruto'] }}</td>
                <td>{{ $item['berat_tarra'] }}</td>
                <td>{{ $item['berat_netto'] }}</td>
                <td>{{ $item['jumlah_grading'] }}</td>
                <td>{{ $item['berat_bersih'] }}</td>
                <td>{{ $item['bjr'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>