<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Payroll Pemupukan dan Perawatan</title>
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
        <h1>Laporan Payroll Pemupukan dan Perawatan - PT GUM</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Estate</th>
                <th>Periode</th>
                <th>Tahun</th>
                <th>Divisi</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Blok</th>
                <th>Tahun Tanam</th>
                <th>Jenis Pekerjaan</th>
                <th>Divisi 2</th>
                <th>Kelompok</th>
                <th>COA</th>
                <th>Keterangan</th>
                <th>T (Rp)</th>
                <th>JJG</th>
                <th>Hasil</th>
                <th>Satuan</th>
                <th>Hasil 2</th>
                <th>Satuan 21</th>
                <th>Total</th>
                <th>Jenis Pupuk</th>
                <th>JM 1</th>
                <th>Qty 1</th>
                <th>Sat 1</th>
                <th>JM 2</th>
                <th>Qty 2</th>
                <th>Sat 2</th>
                <th>JM 3</th>
                <th>Qty 3</th>
                <th>Sat 3</th>
                <th>NIK Mandor</th>
                <th>Nama Mandor</th>
                <th>HK</th>
                <th>HK1</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['periode'] }}</td>
                <td>{{ $item['tahun'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['nik'] }}</td>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['status'] }}</td>
                <td>{{ $item['pembayaran'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tahun_tanam'] }}</td>
                <td>{{ $item['jenis_pekerjaan'] }}</td>
                <td>{{ $item['divisi_2'] }}</td>
                <td>{{ $item['kelompok'] }}</td>
                <td>{{ $item['coa'] }}</td>
                <td>{{ $item['ket'] }}</td>
                <td>{{ $item['t_rp'] }}</td>
                <td>{{ $item['jjg'] }}</td>
                <td>{{ $item['hasil'] }}</td>
                <td>{{ $item['sat'] }}</td>
                <td>{{ $item['hasil_2'] }}</td>
                <td>{{ $item['sat_21'] }}</td>
                <td>{{ $item['total'] }}</td>
                <td>{{ $item['jenis_pupuk'] }}</td>
                <td>{{ $item['jm_1'] }}</td>
                <td>{{ $item['qty_1'] }}</td>
                <td>{{ $item['sat_1'] }}</td>
                <td>{{ $item['jm_2'] }}</td>
                <td>{{ $item['qty_2'] }}</td>
                <td>{{ $item['sat_2'] }}</td>
                <td>{{ $item['jm_3'] }}</td>
                <td>{{ $item['qty_3'] }}</td>
                <td>{{ $item['sat_3'] }}</td>
                <td>{{ $item['nik_mandor'] }}</td>
                <td>{{ $item['nama_mandor'] }}</td>
                <td>{{ $item['hk'] }}</td>
                <td>{{ $item['hk1'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>
