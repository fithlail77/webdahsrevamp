@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Produksi CPO</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadCPO" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
    <!-- Area chart example-->
    <div class="card mb-2">
      <div class="card-header">Grafik Produksi CPO -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="CPOChart" width="100%" height="25"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
    <hr>
    <div class="card mb-2">
      <div class="card-header">Grafik Produksi Kernel -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="PKChart" width="100%" height="25"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-ccpo" width="100%" cellsapcing="0">
                <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>TBS Internal</th>
                            <th>TBS Eksternal</th>
                            <th>Total TBS</th>
                            <th>Total TBS Olah</th>
                            <th>Sisa</th>
                            <th>TBS Olah Internal</th>
                            <th>TBS Olah Eksternal</th>
                            <th>CPO Today</th>
                            <th>CPO Todate</th>
                            <th>Kernel</th>
                            <th>OER</th>
                            <th>KER</th>
                            <th>Stok Tangki 1</th>
                            <th>Stok Tangki 2</th>
                            <th>Stok Jetty</th>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($cpo as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $row->tbs_terima_internal }}</td>
                                <td>{{ $row->tbs_terima_eksternal }}</td>
                                <td>{{ $row->total_tbs_terima }}</td>
                                <td>{{ $row->tbs_olah }}</td>
                                <td>{{ $row->sisa }}</td>
                                <td>{{ $row->tbs_olah_netto_internal }}</td>
                                <td>{{ $row->tbs_olah_netto_eksternal }}</td>
                                <td>{{ $row->cpo_produksi_today }}</td>
                                <td>{{ $row->cpo_produksi_todate }}</td>
                                <td>{{ $row->kernel_produksi }}</td>
                                <td>{{ $row->oer }}</td>
                                <td>{{ $row->ker }}</td>
                                <td>{{ $row->stok_cpo_pks_1 }}</td>
                                <td>{{ $row->stok_cpo_pks_2 }}</td>
                                <td>{{ $row->stok_cpo_jetty_1 }}</td>
                                <td>{{ $row->cpo_despatch_jetty }}</td>
                                <td>{{ $row->cpo_despatch_tongkang }}</td>
                                <td>{{ $row->stok_kernel_sistem_proses_silo_1 }}</td>
                                <td>{{ $row->stok_kernel_sistem_proses_silo_2 }}</td>
                                <td>{{ $row->stok_kernel_gudang }}</td>
                                <td>{{ $row->stok_kernel_st_kernel }}</td>
                                <td>{{ $row->stok_kernel_depan_workshop }}</td>
                                <td>{{ $row->stok_kernel_st_despatch }}</td>
                                <td>{{ $row->stok_kernel_bulking_silo }}</td>
                                <td>{{ $row->stok_kernel_total }}</td>
                                <td>{{ $row->despatch_kernel }}</td>
                                <td>{{ $row->stok_cangkang }}</td>
                                <td>
                                    <a href="{{route('produksicpo.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                        <i class="fas fa-edit fa-sm text-white-50"></i>
                                    </a>
                                    <a href="/produksicpo/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
                                        <i class="fas fa-trash-alt fa-sm text-white-50"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $no++; ?>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal File Upload -->
<div class="modal fade" id="modal-UploadCPO" tabindex="-1" role="dialog" aria-labelledby="modal-UploadCPOLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadCPOLabel">Unggah Produksi CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('produksicpo.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Pilih File Excel</label>
                <input type="file" class="form-control" name="file" id="file" accept=".xlsx, .csv, .xls" required>
                <small class="form-text text-muted">Format file yang didukung: .xlsx, .csv, .xls</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
    .dt-nowrap {
        white-space: nowrap;
    }
</style>
@endsection

@push('scripts')
<script>
        const ctx1 = document.getElementById('CPOChart').getContext('2d');
        const CPOChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'Produksi CPO Bulan Ini',
                    data: @json($chart1),
                    backgroundColor: 'rgba(254, 114, 67, 1)',
                    borderColor: 'rgba(254, 114, 67, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value != null ? value.toLocaleString() : '';
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision:0,
                            callback: function(value) {
                              return value != null ? value.toLocaleString() : ''; // Format ribuan untuk sumbu Y
                            }
                        },
                        title: {
                            display: true,
                            text: 'Ton'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
</script>

<script>
        const ctx2 = document.getElementById('PKChart').getContext('2d');
        const PKChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'Produksi CPO Bulan Ini',
                    data: @json($chart2),
                    backgroundColor: 'rgba(0, 0, 0, 1)',
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value != null ? value.toLocaleString() : '';
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision:0,
                            callback: function(value) {
                              return value != null ? value.toLocaleString() : ''; // Format ribuan untuk sumbu Y
                            }
                        },
                        title: {
                            display: true,
                            text: 'Ton'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
</script> 
@endpush