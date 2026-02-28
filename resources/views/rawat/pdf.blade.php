<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perawatan Bulanan</title>
    <style>
        @page {
            size: A2 landscape;
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
        <h1>Laporan Bulanan Perawatan - PT GUM</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Bulan</th>
                <th>Tahun Jalan</th>
                <th>Tahun</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Blok</th>
                <th>TT</th>
                <th>Kelompok</th>
                <th>COA</th>
                <th>Keterangan</th>
                <th>Tarif Rp</th>
                <th>BJR</th>
                <th>Hasil</th>
                <th>Satuan Hasil</th>
                <th>Hasil 2</th>
                <th>Satuan Hasil 2</th>
                <th>Total</th>
                <th>Periode</th>
                <th>Periode Text</th>
                <th>Tahun Periode</th>
                <th>Estate</th>
                <th>Divisi</th>
                <th>Jenis Pekerjaan</th>
                <th>Areal</th>
                <th>Keterangan</th>
                <th>SPH</th>
                <th>Ha</th>
                <th>HK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['bulan'] }}</td>
                <td>{{ $item['tahun_jalan'] }}</td>
                <td>{{ $item['tahun'] }}</td>
                <td>{{ $item['nik'] }}</td>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['status'] }}</td>
                <td>{{ $item['pembayaran'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tt'] }}</td>
                <td>{{ $item['kelompok'] }}</td>
                <td>{{ $item['coa'] }}</td>
                <td>{{ $item['ket'] }}</td>
                <td>{{ $item['tarif_rp'] }}</td>
                <td>{{ $item['bjr'] }}</td>
                <td>{{ $item['hasil'] }}</td>
                <td>{{ $item['sat'] }}</td>
                <td>{{ $item['hasil_2'] }}</td>
                <td>{{ $item['sat_2'] }}</td>
                <td>{{ $item['total'] }}</td>
                <td>{{ $item['periode'] }}</td>
                <td>{{ $item['period_txt'] }}</td>
                <td>{{ $item['tahun_period'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['jenis_pekerjaan'] }}</td>
                <td>{{ $item['areal'] }}</td>
                <td>{{ $item['keterangan'] }}</td>
                <td>{{ $item['sph'] }}</td>
                <td>{{ $item['ha'] }}</td>
                <td>{{ $item['hk'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>