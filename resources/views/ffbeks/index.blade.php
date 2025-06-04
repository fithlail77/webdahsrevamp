@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">TBS Eksternal</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadFfbEks" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
    <!-- Area chart example-->
    <div class="card mb-2">
      <div class="card-header">Grafik TBS Eksternal GUM -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="FfbEksChart" width="100%" height="25"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
    <hr>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-ffbeks" width="100%" cellsapcing="0">
                <thead>
                        <tr>
                            <th>No</th>
                            <th>No PO</th>
                            <th>Vendor Detail</th>
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
                            <th>Vendor</th>
                            <th>Asal TBS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($ffbeks as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->no_po }}</td>
                            <td>{{ $row->vendor_detail }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $row->time_in }}</td>
                            <td>{{ $row->time_out }}</td>
                            <td>{{ $row->no_plat }}</td>
                            <td>{{ $row->driver }}</td>
                            <td>{{ $row->bruto_awal }}</td>
                            <td>{{ $row->tarra }}</td>
                            <td>{{ $row->ton_bruto }}</td>
                            <td>{{ $row->grading }}</td>
                            <td>{{ $row->netto }}</td>
                            <td>{{ $row->jml_tandan }}</td>
                            <td>{{ $row->bjr }}</td>
                            <td>{{ $row->estate }}</td>
                            <td>{{ $row->asal_tbs }}</td>
                            <td>
                                <a href="{{route('ffbeksternal.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                        <i class="fas fa-edit fa-sm text-white-50"></i>
                                    </a>
                                    <a href="/ffbeksternal/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
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
<div class="modal fade" id="modal-UploadFfbEks" tabindex="-1" role="dialog" aria-labelledby="modal-UploadFfbEksLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadFfbEksLabel">Unggah Data TBS Eksternal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('ffbeksternal.import') }}" method="POST" enctype="multipart/form-data">
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
        const ctx1 = document.getElementById('FfbEksChart').getContext('2d');
        const FfbEksChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'FFB Eksternal',
                    data: @json($values1),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'bottom',
                        formatter: function(value) {
                            return value.toLocaleString('en-US');
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
                              return value.toLocaleString('en-US'); // Format ribuan untuk sumbu Y
                            }
                        },
                        title: {
                            display: true,
                            text: 'Ton Bruto'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
@endpush