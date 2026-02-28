<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pupuk</title>
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
        <h1>Laporan Pupuk</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Issued No</th>
                <th>Material Code</th>
                <th>Material Name</th>
                <th>Unit</th>
                <th>Issued Qty</th>
                <th>Issued Date</th>
                <th>Posting Date</th>
                <th>Storage Location</th>
                <th>Description</th>
                <th>Estate</th>
                <th>Div</th>
                <th>Block1</th>
                <th>Block2</th>
                <th>Years</th>
                <th>TM/TBM</th>
                <th>SAP Issued No</th>
                <th>Kelompok</th>
                <th>Jenis Pupuk</th>
                <th>System Aplikasi</th>
                <th>Areal</th>
                <th>Blok</th>
                <th>TT</th>
                <th>Programs</th>
                <th>Dosis</th>
                <th>Jumlah Pokok</th>
                <th>Ha</th>
                <th>Harga</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['issue_no'] }}</td>
                <td>{{ $item['material_code'] }}</td>
                <td>{{ $item['material_name'] }}</td>
                <td>{{ $item['unit'] }}</td>
                <td>{{ $item['issue_qty'] }}</td>
                <td>{{ $item['issue_date'] }}</td>
                <td>{{ $item['posting_date'] }}</td>
                <td>{{ $item['storage_location'] }}</td>
                <td>{{ $item['description'] }}</td>
                <td>{{ $item['estate'] }}</td>
                <td>{{ $item['div'] }}</td>
                <td>{{ $item['block1'] }}</td>
                <td>{{ $item['block2'] }}</td>
                <td>{{ $item['years'] }}</td>
                <td>{{ $item['tm_tbm'] }}</td>
                <td>{{ $item['sap_issue_no'] }}</td>
                <td>{{ $item['kelompok'] }}</td>
                <td>{{ $item['jenis_pupuk'] }}</td>
                <td>{{ $item['system_aplikasi'] }}</td>
                <td>{{ $item['areal'] }}</td>
                <td>{{ $item['blok'] }}</td>
                <td>{{ $item['tt'] }}</td>
                <td>{{ $item['programs'] }}</td>
                <td>{{ $item['dosis'] }}</td>
                <td>{{ $item['jumlah_pokok'] }}</td>
                <td>{{ $item['ha'] }}</td>
                <td>{{ $item['harga'] }}</td>
                <td>{{ $item['biaya'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>