@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">LHO BBM Input</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddLhoBBM" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadLhoBBM" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable-lho" width="100%" cellsapcing="0">
          <thead>
              <tr>
                <th>No</th>
                <th>No Unit</th>
                <th>Kelompok Unit</th>
                <th>Quantity</th>
                <th>Liter</th>
                <th>Biaya</th>
                <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            @foreach($lhobbm as $row)
              <tr>
                <td>{{ $no }}</td>
                <td>{{ $row->no_unit }}</td>
                <td>{{ $row->kelompok_unit }}</td>
                <td>{{ $row->i_qty }}</td>
                <td>{{ $row->unit }}</td>
                <td>Rp {{ number_format($row->biaya_bbm, 2, ',', '.') }}</td>
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
<div class="modal fade" id="modal-UploadLhoBBM" tabindex="-1" role="dialog" aria-labelledby="modal-UploadLhoBBMLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadLhoBBMLabel">Unggah Data LHO BBM Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('lhobbm.import') }}" method="POST" enctype="multipart/form-data">
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