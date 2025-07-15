@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">LHO Depresiasi Input</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddLhoDepre" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadLhoDepre" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-depre" width="100%" cellsapcing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Unit</th>
                        <th>Nama Unit</th>
                        <th>Tahun Perolehan</th>
                        <th>Deskripsi</th>
                        <th>Nilai Perolehan</th>
                        <th>Depresiasi</th>
                        <th>Nilai Penyusutan</th>
                        <th>Aksi</th>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($lhodepre as $row)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row->no_unit }}</td>
                        <td>{{ $row->nama_unit }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->cap_on)->format('d-m-Y') }}</td>
                        <td>{{ $row->aset_desc }}</td>
                        <td>{{ $row->acq_val }}</td>
                        <td>{{ $row->depre }}</td>
                        <td>{{ $row->penyusutan }}</td>
                        <td>
                            <a href="{{route('depre.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                <i class="fas fa-edit fa-sm text-white-50"></i>
                            </a>
                            <a href="/depre/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
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
<div class="modal fade" id="modal-UploadLhoDepre" tabindex="-1" role="dialog" aria-labelledby="modal-UploadLhoDepreLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadLhoDepreLabel">Unggah Data LHO Depresiasi Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('lhodepre.import') }}" method="POST" enctype="multipart/form-data">
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