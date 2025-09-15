@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Realisasi Panen</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddRealisasiPanen" align="right" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadRealisasiPanen" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="minDate">Dari Tanggal</label>
                <input type="date" id="minDate" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="maxDate">Sampai Tanggal</label>
                <input type="date" id="maxDate" class="form-control">
            </div>
        </div>
        <table id="rpanenTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Pekerjaan</th>
                    <th>Blok</th>
                    <th>Tahun Tanam</th>
                    <th>Divisi</th>
                    <th>Estate</th>
                    <th>Hasil</th>
                    <th>Satuan</th>
                    <th>Jumlah TK</th>
                    <th>Ha Panen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit Realisasi Panen -->
<div class="modal fade" id="modal-EditRealisasiPanen" tabindex="-1" role="dialog" aria-labelledby="modal-EditRealisasiPanenLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditRealisasiPanenLabel">Edit Data Realisasi Panen</h5>
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
                <label for="editTanggal">Tanggal</label>
                <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="editJenisKerja">Jenis Pekerjaan</label>
                <input type="text" class="form-control" id="editJenisKerja" name="jenis_kerja" required>
            </div>
            <div class="form-group">
                <label for="editBlok">Blok</label>
                <input type="text" class="form-control" id="editBlok" name="blok" required>
            </div>
            <div class="form-group">
                <label for="editTt">Tahun Tanam</label>
                <input type="number" class="form-control" id="editTt" name="tt" required>
            </div>
            <div class="form-group">
                <label for="editDivisi">Divisi</label>
                <input type="text" class="form-control" id="editDivisi" name="divisi" required>
            </div>
            <div class="form-group">
                <label for="editEstate">Estate</label>
                <input type="text" class="form-control" id="editEstate" name="estate" required>
            </div>
            <div class="form-group">
                <label for="editHasil">Hasil</label>
                <input type="number" step="0.01" class="form-control" id="editHasil" name="hasil" required>
            </div>
            <div class="form-group">
                <label for="editSatuan">Satuan</label>
                <input type="text" class="form-control" id="editSatuan" name="satuan" required>
            </div>
            <div class="form-group">
                <label for="editTk">Jumlah TK</label>
                <input type="number" class="form-control" id="editTk" name="tk" required>
            </div>
            <div class="form-group">
                <label for="editHaPanen">Ha Panen</label>
                <input type="number" step="0.01" class="form-control" id="editHaPanen" name="ha_panen" required>
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
<div class="modal fade" id="modal-UploadRealisasiPanen" tabindex="-1" role="dialog" aria-labelledby="modal-UploadRealisasiPanenLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadRealisasiPanenLabel">Unggah Data Realisasi Panen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('realisasipanen.import') }}" method="POST" enctype="multipart/form-data">
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
    $(document).ready(function() {
    var table = $('#rpanenTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('realisasipanen.data') }}",
            data: function(d) {
                d.minDate = $('#minDate').val();
                d.maxDate = $('#maxDate').val();
            }
        },
        drawCallback: function() {
            console.log('Table drawn');
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'tanggal_formatted', name: 'tanggal_formatted' },
            { data: 'jenis_kerja', name: 'jenis_kerja' },
            { data: 'blok', name: 'blok' },
            { data: 'tt', name: 'tt' },
            { data: 'divisi', name: 'divisi' },
            { data: 'estate', name: 'estate' },
            { data: 'hasil', name: 'hasil' },
            { data: 'satuan', name: 'satuan' },
            { data: 'tk', name: 'tk'},
            { data: 'ha_panen', name: 'ha_panen'},
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });

    $('#minDate, #maxDate').on('change', function() {
        table.ajax.reload();
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
        $.get('/realisasipanen/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editJenisKerja').val(data.jenis_kerja);
            $('#editBlok').val(data.blok);
            $('#editTt').val(data.tt);
            $('#editDivisi').val(data.divisi);
            $('#editEstate').val(data.estate);
            $('#editHasil').val(data.hasil);
            $('#editSatuan').val(data.satuan);
            $('#editTk').val(data.tk);
            $('#editHaPanen').val(data.ha_panen);
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
            url: '/realisasipanen/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditRealisasiPanen').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan saat memperbarui data.');
            }
        });
    });
});
</script>
@endpush