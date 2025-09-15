@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Payroll Pemupukan dan Perawatan</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadPayroll" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-payroll" width="100%" cellsapcing="0">
                <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Estate</th>
                            <th>Nama Tenaga</th>
                            <th>Jenis Pupuk</th>
                            <th>Quantiti</th>
                            <th>Mandoran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach($payroll as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $row->estate }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->jenis_pupuk }}</td>
                                <td>{{ $row->qty_1 }} {{ $row->sat_1 }}</td>
                                <td>{{ $row->nama_mandor }}</td>
                                <td>
                                        <a href="{{route('payroll.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                            <i class="fas fa-edit fa-sm text-white-50"></i>
                                        </a>
                                        <a href="/payroll/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
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
<div class="modal fade" id="modal-UploadPayroll" tabindex="-1" role="dialog" aria-labelledby="modal-UploadPayrollLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadPayrollLabel">Unggah Data Payroll Pemupukan Perawatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('payroll.import') }}" method="POST" enctype="multipart/form-data">
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