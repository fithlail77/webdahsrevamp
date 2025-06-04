@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Perusahaan</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-add" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-comp" width="100%" cellsapcing="0">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Perusahaan</td>
                        <td>Estate</td>
                        <td>Divisi</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ( $Company as $row )
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row->perusahaan }}</td>
                        <td>{{ $row->estate }}</td>
                        <td>{{ $row->divisi }}</td>
                        <td>
                            <a href="{{route('comp.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                <i class="fas fa-edit fa-sm text-white-50"></i>
                            </a>
                            <a href="/comp/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
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

<!-- Modal Tambah Data -->
<div class="modal inmodal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xs">
    <form name="frm_add" id="frm_add" class="form-horiontal" action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Tambah Data</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Kode Perusahaan</label>
                        <div class="col-lg-10">
                            <select id="kd_comp" name="kd_comp" class="form-control" required>
                                <option value="">--Pilih--</option>
                                <option value="GUM">GUM</option>
                                <option value="PAM">PAM</option>
                                <option value="TBSM">TBSM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Nama Perusahaan</label>
                        <div class="col-lg-10">
                            <input type="text" name="perusahaan" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Kode Estate</label>
                        <div class="col-lg-10">
                            <input type="text" name="kd_est" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Estate</label>
                        <div class="col-lg-10">
                            <input type="text" name="estate" required class="form-control">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Divisi</label>
                        <div class="col-lg-10">
                            <input type="text" name="divisi" required class="form-control">
                        </div>
                    </div>                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection