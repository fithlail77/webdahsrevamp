@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Koordinat Blok</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <a href="{{ route('blokkoordinat.create') }}">
                <button class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </a> 
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadBlokKoordinat">
                <i class="fa fa-upload"></i> Upload
            </button>
        </div>
        <div>
            <button class="btn btn-success btn-sm btn-flat" id="exportExcel">
                <i class="fa fa-file-excel"></i> Export Excel
            </button>
            <button class="btn btn-danger btn-sm btn-flat" id="exportPdf">
                <i class="fa fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
            <table id="blokkoordinatTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Blok</th>
                        <th>x</th>
                        <th>y</th>
                        <th>L1</th>
                        <th>L2</th>
                        <th>Poly ID</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        <div id="noDataMessage" class="alert alert-warning mt-3" style="display:none;">
            Tidak ada data yang tersedia.
        </div>
    </div>
</div>
<!-- Modal Edit Blok Koordinat -->
<div class="modal fade" id="modal-EditBlokKordinat" tabindex="-1" role="dialog" aria-labelledby="modal-EditBlokKordinatLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditBlokKordinatLabel">Ubah Data Koordinat Blok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editId" name="id">
            <div class="form-group">
                <label for="editEstate">Estate</label>
                <input type="text" class="form-control" id="editEstate" name="estate" required>
            </div>
            <div class="form-group">
                <label for="editDivisi">Divisi</label>
                <input type="text" class="form-control" id="editDivisi" name="divisi" required>
            </div>
            <div class="form-group">
                <label for="editBlok">Blok</label>
                <input type="text" class="form-control" id="editBlok" name="blok" required>
            </div>
            <div class="form-group">
                <label for="editX">X</label>
                <input type="text" class="form-control" id="editX" name="x" required>
            </div>
            <div class="form-group">
                <label for="editY">Y</label>
                <input type="text" class="form-control" id="editY" name="y" required>
            </div>
            <div class="form-group">
                <label for="editL1">L1</label>
                <input type="number" class="form-control" id="editL1" name="l1" required>
            </div>
            <div class="form-group">
                <label for="editL2">L2</label>
                <input type="number" class="form-control" id="editL2" name="l2" required>
            </div>
            <div class="form-group">
                <label for="editPolyId">Poly ID</label>
                <input type="number" class="form-control" id="editPolyId" name="poly_id" required>
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

<!-- Modal File Upload -->
<div class="modal fade" id="modal-UploadBlokKoordinat" tabindex="-1" role="dialog" aria-labelledby="modal-UploadBlokKoordinatLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadBlokKoordinatLabel">Unggah Data Koordinat Blok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('blokkoordinat.import') }}" method="POST" enctype="multipart/form-data">
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

@push('scripts')
<script>
    var table;
    $(document).ready(function() {
    table = $('#blokkoordinatTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('blokkoordinat.data') }}"
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
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'blok', name: 'blok' },
            { data: 'x', name: 'x' },
            { data: 'y', name: 'y' },
            { data: 'l1', name: 'l1' },
            { data: 'l2', name: 'l2' },
            { data: 'poly_id', name: 'poly_id' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });


    // Handle export buttons
    $('#exportExcel').on('click', function() {
        var url = "{{ route('blokkoordinat.export.excel') }}";
        window.location.href = url;
    });

    $('#exportPdf').on('click', function() {
        var url = "{{ route('blokkoordinat.export.pdf') }}";
        window.location.href = url;
    });

    // Handle edit button click
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        console.log('ID:', id);
        console.log('data-id attr:', $(this).attr('data-id'));
        if (id == null || id === "") {
            console.error('ID is empty');
            return;
        }
        $.get('/blokkoordinat/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editBlok').val(data.blok);
            $('#editX').val(data.x);
            $('#editY').val(data.y);
            $('#editL1').val(data.l1);
            $('#editL2').val(data.l2);
            $('#editPolyId').val(data.poly_id);
        }).fail(function(xhr, status, error) {
            console.error('Error fetching edit data:', status, error);
            toastr.error('Gagal memuat data untuk edit.');
        });
    });

    // Handle edit form submission
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editId').val();
        var formData = $(this).serialize();
        $.ajax({
            url: '/blokkoordinat/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                setTimeout(function() {
                    $('#modal-EditBlokKordinat').modal('hide');
                }, 100);
                toastr.success(response.success);
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
});
</script>
@endpush
