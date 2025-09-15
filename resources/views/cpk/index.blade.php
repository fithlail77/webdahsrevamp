@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Kontrak Kernel</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadCPK" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
</div>
<div class="card shadow mb-4">
    <!-- Area chart example-->
    <div class="card mb-2">
      <div class="card-header">Price/Kg CPO</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="CPKChart" width="100%" height="20"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-cpk" width="100%" cellsapcing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>LTC</th>
                        <th>No SC</th>
                        <th>Tanggal Pricing</th>
                        <th>Tanggal Kirim</th>
                        <th>Tanggal Selesai Kirim</th>
                        <th>Kuantiti Kontrak</th>
                        <th>Pembeli</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($cpk as $row)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row->ltc }}</td>
                        <td>{{ $row->nomor_sc }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->date_pricing)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->actual_awal_kirim)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->actual_closed_kirim)->format('d-m-Y') }}</td>
                        <td>{{ $row->qty_kontrak_kg }}</td>
                        <td>{{ $row->buyer }}</td>
                        <td>{{ $row->status }}</td>
                        <td>
                            <a href="{{route('contractpk.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                <i class="fas fa-edit fa-sm text-white-50"></i>
                            </a>
                            <a href="/contractpk/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
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
<div class="modal fade" id="modal-UploadCPK" tabindex="-1" role="dialog" aria-labelledby="modal-UploadCPKLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadCPKLabel">Unggah Kontrak CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('contractpk.import') }}" method="POST" enctype="multipart/form-data">
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
    const ctx = document.getElementById('CPKChart').getContext('2d');
    const CPKChart = new Chart(ctx, {
        data: {
            labels: @json($labels1), // label1 dan label2 sama
            datasets: [
                {
                    type: 'bar',
                    label: 'Qty Kernel (Kg)',
                    data: @json($values2),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'yQty',
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return Math.round(value).toLocaleString('id-ID') + ' Kg';
                        },
                        color: '#000',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                {
                    type: 'line',
                    label: 'Price/Kg Kernel',
                    data: @json($values1),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    yAxisID: 'yPrice',
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return 'Rp ' + Math.round(value).toLocaleString('id-ID');
                        },
                        color: '#000',
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed.y;
                            if (context.dataset.label.includes('Price')) {
                                return 'Rp ' + Math.round(value).toLocaleString('id-ID');
                            } else {
                                return Math.round(value).toLocaleString('id-ID') + ' Kg';
                            }
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                yQty: {
                    type: 'linear',
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Qty (Kg)'
                    },
                    ticks: {
                        callback: function(value) {
                            return Math.round(value).toLocaleString('id-ID') + ' Kg';
                        }
                    }
                },
                yPrice: {
                    type: 'linear',
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Price (Rp)'
                    },
                    grid: {
                        drawOnChartArea: false
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + Math.round(value).toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
    
@endpush