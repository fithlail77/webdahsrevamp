<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Realisasi Rental Kenderaan dan Alat Berat</title>
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
        <h1>Laporan Realisasi Rental Kenderaan dan Alat Berat</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Estate</th>
                <th>Jenis Alat</th>
                <th>Nomor Alat</th>
                <th>Operator</th>
                <th>HM Awal</th>
                <th>HM Akhir</th>
                <th>Total HM</th>
                <th>Potongan HM</th>
                <th>Pembayaran HM</th>
                <th>Blok</th>
                <th>Tahun Tanam</th>
                <th>Pekerjaan</th>
                <th>Divisi</th>
                <th>Kelompok</th>
                <th>COA</th>
                <th>Tarif</th>
                <th>BJR</th>
                <th>Hasil 1</th>
                <th>SAtuan 1</th>
                <th>Hasil 2</th>
                <th>Satuan 2</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['jenis_alat'] }}</td>
                <td>{{ $item['no_alat'] }}</td>
                <td>{{ $item['operator'] }}</td>
                <td>{{ $item['hm_awal'] }}</td>
                <td>{{ $item['hm_akhir'] }}</td>
                <td>{{ $item['total_hm'] }}</td>
                <td>{{ $item['potongan_hm'] }}</td>
                <td>{{ $item['pembayaran_hm'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tahun_tanam'] }}</td>
                <td>{{ $item['pekerjaan'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['kelompok'] }}</td>
                <td>{{ $item['coa'] }}</td>
                <td>{{ $item['tarif'] }}</td>
                <td>{{ $item['bjr'] }}</td>
                <td>{{ $item['hasil_1'] }}</td>
                <td>{{ $item['satuan_1'] }}</td>
                <td>{{ $item['hasil_2'] }}</td>
                <td>{{ $item['satuan_2'] }}</td>
                <td>{{ $item['total_biaya'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>