<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penerimaan TBS Internal Pabrik</title>
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
        <h1>Laporan Penerimaan TBS Internal Pabrik</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No PO</th>
                  <th>Vendor Detail</th>
                  <th>Vendor Group</th>
                  <th>Vendor Transportir</th>
                  <th>Tgl</th>
                  <th>Bln</th>
                  <th>Thn</th>
                  <th>Tanggal</th>
                  <th>Jam Masuk</th>
                  <th>Jam Keluar</th>
                  <th>Plat Kenderaan</th>
                  <th>Supir</th>
                  <th>Bruto Awal</th>
                  <th>Tarra</th>
                  <th>Ton Bruto</th>
                  <th>Grading</th>
                  <th>Netto</th>
                  <th>Janjang</th>
                  <th>BJR</th>
                  <th>Area</th>
                  <th>Umur Tanaman (Thn)</th>
                  <th>Bulan</th>
                  <th>Estate</th>
                  <th>Divisi</th>
                  <th>Asal TBS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['no_po'] }}</td>
                <td>{{ $item['vendor_detail'] }}</td>
                <td>{{ $item['vendor_group'] }}</td>
                <td>{{ $item['vendor_transportir'] }}</td>
                <td>{{ $item['tgl'] }}</td>
                <td>{{ $item['bln'] }}</td>
                <td>{{ $item['thn'] }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['time_in'] }}</td>
                <td>{{ $item['time_out'] }}</td>
                <td>{{ $item['no_plat'] }}</td>
                <td>{{ $item['driver'] }}</td>
                <td>{{ $item['bruto_awal'] }}</td>
                <td>{{ $item['tarra'] }}</td>
                <td>{{ $item['ton_bruto'] }}</td>
                <td>{{ $item['grading'] }}</td>
                <td>{{ $item['netto'] }}</td>
                <td>{{ $item['jml_tandan'] }}</td>
                <td>{{ $item['bjr'] }}</td>
                <td>{{ $item['area'] }}</td>
                <td>{{ $item['umur_tanaman'] }}</td>
                <td>{{ $item['bulan'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['divisi'] }}</td>
                <td>{{ $item['asal_tbs'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>