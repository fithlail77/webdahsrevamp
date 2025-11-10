<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daily Produksi CPO</title>
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
        <h1>Laporan Daily Produksi CPO</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>TBS Internal</th>
                <th>% TBS Internal</th>
                <th>TBS Eksternal</th>
                <th>% TBS Eksternal</th>
                <th>Total TBS Terima</th>
                <th>Total TBS Olah</th>
                <th>Sisa TBS</th>
                <th>CPO Today</th>
                <th>CPO Todate</th>
                <th>Kernel</th>
                <th>OER</th>
                <th>KER</th>
                <th>Oil Loss</th>
                <th>Kernel Loss</th>
                <th>Storage CPO 1</th>
                <th>Storage CPO 2</th>
                <th>Storage Jetty</th>
                <th>Despatch Jetty</th>
                <th>Despatch Tongkang</th>
                <th>Kernel Silo 1</th>
                <th>Kernel Silo 2</th>
                <th>Kernel Gudang</th>
                <th>Kernel Station</th>
                <th>Kernel Workshop</th>
                <th>Kernel St Despatch</th>
                <th>Kernel Bulking Silo</th>
                <th>Stok Kernel Total</th>
                <th>Despatch Kernel</th>
                <th>Cangkang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td>{{ $item['tbs_terima_internal'] }}</td>
                <td>{{ $item['persen_terima_internal'] }}</td>
                <td>{{ $item['tbs_terima_eksternal'] }}</td>
                <td>{{ $item['persen_terima_eksternal'] }}</td>
                <td>{{ $item['total_tbs_terima'] }}</td>
                <td>{{ $item['tbs_olah'] }}</td>
                <td>{{ $item['sisa'] }}</td>
                <td>{{ $item['cpo_produksi_today'] }}</td>
                <td>{{ $item['cpo_produksi_todate'] }}</td>
                <td>{{ $item['kernel_produksi'] }}</td>
                <td>{{ $item['oer'] }}</td>
                <td>{{ $item['ker'] }}</td>
                <td>{{ $item['oil_loss'] }}</td>
                <td>{{ $item['kernel_loss'] }}</td>
                <td>{{ $item['stok_cpo_pks_1'] }}</td>
                <td>{{ $item['stok_cpo_pks_2'] }}</td>
                <td>{{ $item['stok_cpo_jetty_1'] }}</td>
                <td>{{ $item['cpo_despatch_jetty'] }}</td>
                <td>{{ $item['cpo_despatch_tongkang'] }}</td>
                <td>{{ $item['stok_kernel_sistem_proses_silo_1'] }}</td>
                <td>{{ $item['stok_kernel_sistem_proses_silo_2'] }}</td>
                <td>{{ $item['stok_kernel_gudang'] }}</td>
                <td>{{ $item['stok_kernel_st_kernel'] }}</td>
                <td>{{ $item['stok_kernel_depan_workshop'] }}</td>
                <td>{{ $item['stok_kernel_st_despatch'] }}</td>
                <td>{{ $item['stok_kernel_bulking_silo'] }}</td>
                <td>{{ $item['stok_kernel_total'] }}</td>
                <td>{{ $item['despatch_kernel'] }}</td>
                <td>{{ $item['stok_cangkang'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ count($data) }} record(s)</p>
    </div>
</body>
</html>