<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Areal Statement PT GUM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 2px 4px;
            text-align: left;
            font-size: 8px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Areal Statement PT GUM</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
        @if(count($data) >= $limit)
        <p><strong>Catatan: Menampilkan {{ count($data) }} data pertama dari total data.</strong></p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5px;">No</th>
                <th>Estate</th>
                <th>Divisi</th>
                <th>Blok</th>
                <th>Lahan</th>
                <th>Thn Tanam</th>
                <th>Bibit</th>
                <th>Topo</th>
                <th>Jns Tanah</th>
                <th>Status</th>
                <th>Jml Pokok</th>
                <th>Luas</th>
                <th>SPH</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->estate }}</td>
                <td>{{ $item->divisi }}</td>
                <td>{{ $item->blok }}</td>
                <td>{{ $item->lahan }}</td>
                <td>{{ $item->tahun_tanam }}</td>
                <td>{{ $item->bibit }}</td>
                <td>{{ $item->topografi }}</td>
                <td>{{ $item->jenis_tanah }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->jml_pokok }}</td>
                <td>{{ $item->luas }}</td>
                <td>{{ $item->sph }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>