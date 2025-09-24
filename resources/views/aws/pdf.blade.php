<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AWS Weather Station Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 14px;
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
        <h1>Laporan Data AWS Weather Station</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Tanggal</th>
                <th>Suhu (°C)</th>
                <th>Kelembaban (%)</th>
                <th>Solar Radiation (W/m²)</th>
                <th>Curah Hujan (mm)</th>
                <th>Tekanan Udara (mb)</th>
                <th>Kecepatan Angin (m/s)</th>
                <th>Arah Angin (°)</th>
                <th>ET (mm)</th>
                <th>Sinar Matahari (h/d)</th>
                <th>Ultraviolet (index)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['time'] }}</td>
                <td>{{ $item['date'] }}</td>
                <td>{{ $item['temp'] }}</td>
                <td>{{ $item['humid'] }}</td>
                <td>{{ $item['sol_rad'] }}</td>
                <td>{{ $item['rainfall'] }}</td>
                <td>{{ $item['air_pres'] }}</td>
                <td>{{ $item['wind_speed'] }}</td>
                <td>{{ $item['wind_dir'] }}</td>
                <td>{{ $item['et'] }}</td>
                <td>{{ $item['sunshine'] }}</td>
                <td>{{ $item['index_uv'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>