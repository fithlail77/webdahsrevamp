@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Pengguna</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-add" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-user" width="100%" cellsapcing="0">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Email</td>
                        <td>Estate</td>
                        <td>Role Akses</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ( $user as $row )
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->estate }}</td>
                        <td>
                            @foreach ($row->roles as $r)
                            {{ $r->name }}
                            @endforeach
                        </td>
                        <td>
                            <a href="{{route('user.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                <i class="fas fa-edit fa-sm text-white-50"></i>
                            </a>
                            <a href="{{route('user.show' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" title="Ganti Kata Sandi">
                                <i class="fas fa-key fa-sm text-white-50"></i>
                            </a>
                            <a href="/user/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
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
                        <label class="col-lg-20 control-label">Nama User</label>
                        <div class="col-lg-10">
                            <input type="text" name="username" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="email" name="email" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Estate</label>
                        <div class="col-lg-10">
                            <select name="estate" class="form-control" required>
                                <option value="">--Pilih Akses--</option>
                                <option value="All">All</option>
                                <option value="Melamor">Melamor</option>
                                <option value="Sedadung">Sedadung</option>
                                <option value="Tugang">Tugang</option>
                                <option value="Mulau">Mulau</option>
                                <option value="Ngaring">Ngaring</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-20 control-label">Akses</label>
                        <div class="col-lg-10">
                            <select id="roles" name="roles" class="form-control" required>
                                <option value="">--Pilih Akses--</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="ke">Kerani Estate</option>
                                <option value="dc">Data Center</option>
                                <option value="kcpo">Admin Mill</option>
                                <option value="user">User</option>
                            </select>
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
