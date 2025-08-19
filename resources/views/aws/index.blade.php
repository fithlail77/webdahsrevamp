@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">AWS Weather Station</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAWS" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadAWS" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>  
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-ffbint" width="100%" cellsapcing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Suhu (&degC)</th>
                        <th>Kelembaban (%)</th>
                        <th>Solar Radiation(W/m&sup2;)</th>
                        <th>Curah Hujan (mm)</th>
                        <th>Tekanan Udara (mb)</th>
                        <th>Kecepatan Angin (m/s)</th>
                        <th>Arah Angin (&deg)</th>
                        <th>ET (mm)</th>
                        <th>Sinar Matahari (h/d)</th>
                        <th>Ultraviolet (index)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($awsinput as $row)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ number_format($row->temp, 2) }}</td>
                        <td>{{ number_format($row->hum, 2) }}</td>
                        <td>{{ number_format($row->solrad, 2) }}</td>
                        <td>{{ number_format($row->hujan, 2) }}</td>
                        <td>{{ number_format($row->air_pres, 2) }}</td>
                        <td>{{ number_format($row->wind_speed, 2) }}</td>
                        <td>{{ number_format($row->wind_dir, 2) }}</td>
                        <td>{{ number_format($row->et, 2) }}</td>
                        <td>{{ number_format($row->sunshine, 2) }}</td>
                        <td>{{ number_format($row->uv, 2) }}</td>
                        <td>
                            <a href="{{route('awsinput.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                <i class="fas fa-edit fa-sm text-white-50"></i>
                            </a>
                            <a href="/awsinput/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
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
<div class="modal fade" id="modal-UploadAWS" tabindex="-1" role="dialog" aria-labelledby="modal-UploadAWSLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadLhoInputLabel">Unggah Data AWS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('awsinput.import') }}" method="POST" enctype="multipart/form-data">
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
@endsection