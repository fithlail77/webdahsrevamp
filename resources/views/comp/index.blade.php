@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Perusahaan</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddComp" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-striped" id="compTable">
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
            </tbody>
        </table>
        <div id="noDataMessage" class="alert alert-warning mt-3" style="display:none;">
            Tidak ada data yang sesuai dengan filter tanggal.
        </div>
    </div>
</div>
<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-AddComp" tabindex="-1" role="dialog" aria-labelledby="modal-AddCompLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs">
    <form name="frm_add" id="frm_add" class="form-horiontal" action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Tambah Data Perusahaan</h4>
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
<!-- Modal Edit Data Comp -->
<div class="modal fade" id="modal-EditComp" tabindex="-1" role="dialog" aria-labelledby="modal-EditCompLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditCompLabel">Ubah Data Perusahaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editId" name="id">
            <div class="table-responsive">
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Perusahaan</label>
                        <input class="form-control" id="editPerusahaan" name="perusahaan" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kode Estate</label>
                        <input class="form-control" id="editKdEst" name="kd_est" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Estate</label>
                        <select class="form-control" id="editEstate" name="estate" required>
                            <option value="">-- Pilih --</option>
                            @foreach($estate as $item)
                                <option value="{{ $item->estate }}">{{ $item->estate }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Divisi</label>
                        <select class="form-control" id="editDivisi" name="divisi" required>
                            <option value="">-- Pilih --</option>
                            @foreach($divisi as $item)
                                <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    var table;
    $(document).ready(function() {
        table = $('#compTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            responsive: false,
            autoWidth: false,
            ajax: {
                url: "{{ route('comp.data') }}",
            },
            drawCallback: function(settings) {
                var api = this.api();
                var dataCount = api.data().count();
                if (dataCount === 0) {
                    $('#noDataMessage').show();
                } else {
                    $('#noDataMessage').hide();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'perusahaan', name: 'perusahaan' },
                { data: 'estate', name: 'estate' },
                { data: 'divisi', name: 'divisi' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });
    });
    //Handle Edit Button Click
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        console.log('ID:', id);
        console.log('data-id attr:', $(this).attr('data-id'));
        if (id == null || id === "") {
            console.error('ID is empty');
            return;
        }
        $.get('/comp/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editPerusahaan').val(data.perusahaan);
            $('#editKdEst').val(data.kd_est);
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
        }).fail(function(xhr, status, error) {
            console.error('Error fetching edit data:', status, error);
            toastr.error('Gagal memuat data untuk edit.');
        });
    });
    // Handle Edit Form Submission
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editId').val();
        var formData = $(this).serialize();
        $.ajax({
            url: '/comp/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                toastr.success(response.success);
                $('#modal-EditComp').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = [];
                    for (var field in errors) {
                        errorMessages.push(errors[field].join(', '));
                    }
                    toastr.error('Validasi gagal: ' + errorMessages.join('; '));
                } else if (xhr.status === 500 && xhr.responseJSON && xhr.responseJSON.error) {
                    toastr.error('Kesalahan server: ' + xhr.responseJSON.error);
                } else {
                    toastr.error('Terjadi kesalahan saat memperbarui data.');
                }
            }
        });
    });
</script>
@endpush