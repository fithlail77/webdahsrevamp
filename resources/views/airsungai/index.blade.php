@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Ketinggian Air Sungai Kapuas</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadAirSungai" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
<!-- Area chart example-->
<div class="card mb-2">
    <div class="card-header">Grafik Air Sungai Kapuas</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="AirSungaiChart1" width="100%" height="20"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-sungai1" width="100%" cellsapcing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tinggi Air Pagi</th>
                        <th>Tinggi Air Sore</th>
                        <th>Rata-rata</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($sungai as $row )
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $row->pagi_m }}</td>
                        <td>{{ $row->sore_m }}</td>
                        <td>{{ $row->rataan }}</td>
                        <td>
                            <a href="{{route('airsungai.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                <i class="fas fa-edit fa-sm text-white-50"></i>
                            </a>
                            <a href="/airsungai/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
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
<div class="modal fade" id="modal-UploadAirSungai" tabindex="-1" role="dialog" aria-labelledby="modal-UploadAirSungaiLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadAirSungaiLabel">Unggah Data Air Sungai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('airsungai.import') }}" method="POST" enctype="multipart/form-data">
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

<!-- Modal Tambah Aresta -->
<div class="modal fade" id="modal-AddAirSungai" tabindex="-1" role="dialog" aria-labelledby="modal-AddAirSungaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddAirSungaiLabel">Tambah Data Air Sungai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('airsungai.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-borderless" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Tanggal</th>
                            <th width="10%">Tinggi Air Pagi</th>
                            <th width="10%">Tinggi Air Sore</th>
                            <th width="10%">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required></td>
                            <td><input type="number" name="pagi_m" class="form-control" min="0" step="0.1"></td>
                            <td><input type="number" name="sore_m" class="form-control" min="0" step="0.1"></td>
                            <td><input type="number" name="rataan" class="form-control" min="0" step="0.1"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right mt-3">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    const labels1 = @json($labels1);
    const values1 = @json($values1);
    const batasAtas = Array(values1.length).fill(800);
    const batasBawah = Array(values1.length).fill(400);

    const ctx1 = document.getElementById('AirSungaiChart1').getContext('2d');
    const AirSungaiChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: labels1,
            datasets: [{
                label: 'Tinggi Air Sungai',
                data: values1,
                fill: false,
                borderColor: 'rgba(54, 162, 235, 1)',
                tension: 0.3,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointRadius: 3,
                },
                {
                label: 'Batas Atas',
                data: batasAtas,
                borderColor: 'gold',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                },
                {
                label: 'Batas Bawah',
                data: batasBawah,
                borderColor: 'navy',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: 200,
                    suggestedMax: 1100
                }
            }
        }
    });
</script>
    
@endpush