@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Laporan SPTBS</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <!--<button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddSptbs" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>-->
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadSptbs">
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
        <div>
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
            <table id="sptbsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Angkutan</th>
                        <th>No Tiket</th>
                        <th>Tanggal Tiket</th>
                        <th>No SPTBS</th>
                        <th>Tanggal SPTBS</th>
                        <th>Tanggal Panen</th>
                        <th>Nama Supir</th>
                        <th>No Polisi</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Blok</th>
                        <th>Tahun Tanam</th>
                        <th>Lahan</th>
                        <th>Jumlah Tandan</th>
                        <th>Berondolan</th>
                        <th>Berat Bruto</th>
                        <th>Berat Tarra</th>
                        <th>Berat Netto</th>
                        <th>Jumlah Grading</th>
                        <th>Berat Bersih</th>
                        <th>BJR</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit Realisasi Panen -->
<div class="modal fade" id="modal-EditSptbs" tabindex="-1" role="dialog" aria-labelledby="modal-EditSptbsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditSptbsLabel">Edit Data SPTBS</h5>
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
                <label for="editAngkutan">Angkutan</label>
                <input type="text" class="form-control" id="editAngkutan" name="Angkutan" required>
            </div>
            <div class="form-group">
                <label for="editNoTiket">No Tiket</label>
                <input type="text" class="form-control" id="editNoTiket" name="no_tiket" required>
            </div>
            <div class="form-group">
                <label for="editTanggalTiket">Tanggal Tiket</label>
                <input type="date" class="form-control" id="editTanggalTiket" name="tanggal_tiket" required>
            </div>
            <div class="form-group">
                <label for="editNoSptbs">No SPTBS</label>
                <input type="text" class="form-control" id="editNoSptbs" name="no_sptbs" required>
            </div>
            <div class="form-group">
                <label for="editTanggalSptbs">Tanggal SPTBS</label>
                <input type="date" class="form-control" id="editTanggalSptbs" name="tanggal_sptbs" required>
            </div>
            <div class="form-group">
                <label for="editTanggalPanen">Tanggal Panen</label>
                <input type="date" class="form-control" id="editTanggalPanen" name="tanggal_panen" required>
            </div>
            <div class="form-group">
                <label for="editNamaSupir">Nama Supir</label>
                <input type="text" class="form-control" id="editNamaSupir" name="Nama Supir" required>
            </div>
            <div class="form-group">
                <label for="editNoPolisi">No Polisi</label>
                <input type="text" class="form-control" id="editNoPolisi" name="no_polisi" required>
            </div>
            <div class="form-group">
                <label for="editJamMasuk">Jam Masuk</label>
                <input type="time" class="form-control" id="editJamMasuk" name="jam_masuk">
            </div>
            <div class="form-group">
                <label for="editJamKeluar">Jam Keluar</label>
                <input type="time" class="form-control" id="editJamKeluar" name="jam_keluar">
            </div>
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
                <label for="editTahunTanam">Tahun Tanam</label>
                <input type="text" class="form-control" id="editTahunTanam" name="tahun_tanam" required>
            </div>
            <div class="form-group">
                <label for="editLahan">Lahan</label>
                <input type="text" class="form-control" id="editLahan" name="lahan" required>
            </div>
            <div class="form-group">
                <label for="editJumlahTandan">Jumlah Tandan</label>
                <input type="text" class="form-control" id="editJumlahTandan" name="jumlah_tandan" required>
            </div>
            <div class="form-group">
                <label for="editBerondolan">Berondolan</label>
                <input type="number" step="0.01" class="form-control" id="editBerondolan" name="berondolan" required>
            </div>
            <div class="form-group">
                <label for="editBeratBruto">Berat Bruto</label>
                <input type="number" class="form-control" id="editBeratBruto" name="berat_bruto" required>
            </div>
            <div class="form-group">
                <label for="editBeratTarra">Berat Tarra</label>
                <input type="number" class="form-control" id="editBeratTarra" name="berat_tarra" required>
            </div>
            <div class="form-group">
                <label for="editBeratNetto">Berat Netto</label>
                <input type="number" class="form-control" id="editBeratNetto" name="berat_netto" required>
            </div>
            <div class="form-group">
                <label for="editJumlahGrading">Jumlah Grading</label>
                <input type="number" class="form-control" id="editJumlahGrading" name="jumlah_grading" required>
            </div>
            <div class="form-group">
                <label for="editBeratBersih">Berat Bersih</label>
                <input type="number" class="form-control" id="editBeratBersih" name="berat_bersih" required>
            </div>
            <div class="form-group">
                <label for="editBjr">BJR</label>
                <input type="number" step="0.01" class="form-control" id="editBjr" name="bjr" required>
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
<div class="modal fade" id="modal-UploadSptbs" tabindex="-1" role="dialog" aria-labelledby="modal-UploadSptbsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadSptbsLabel">Unggah Data Realisasi Panen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('sptbs.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#sptbsTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('sptbs.data') }}",
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
            { data: 'angkutan', name: 'angkutan' },
            { data: 'no_tiket', name: 'no_tiket' },
            { data: 'tanggal_formatted1', name: 'tanggal_formatted1' },
            { data: 'no_sptbs', name: 'no_sptbs' },
            { data: 'tanggal_formatted2', name: 'tanggal_formatted2' },
            { data: 'tanggal_formatted3', name: 'tanggal_formatted3' },
            { data: 'nama_supir', name: 'nama_supir' },
            { data: 'no_polisi', name: 'no_polisi' },
            { data: 'jam_masuk', name: 'jam_masuk' },
            { data: 'jam_keluar', name: 'jam_keluar' },
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'blok', name: 'blok' },
            { data: 'tahun_tanam', name: 'tahun_tanam' },
            { data: 'lahan', name: 'lahan' },
            { data: 'jumlah_tandan', name: 'jumlah_tandan' },
            { data: 'berondolan', name: 'berondolan' },
            { data: 'berat_bruto', name: 'berat_bruto' },
            { data: 'berat_tarra', name: 'berat_tarra' },
            { data: 'berat_netto', name: 'berat_netto' },
            { data: 'jumlah_grading', name: 'jumlah_grading' },
            { data: 'berat_bersih', name: 'berat_bersih' },
            { data: 'bjr', name: 'bjr' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });

    $('#minDate, #maxDate').on('change', function() {
        table.ajax.reload();
    });

    // Handle export buttons
    $('#exportExcel').on('click', function() {
        var minDate = $('#minDate').val();
        var maxDate = $('#maxDate').val();
        var url = "{{ route('sptbs.export.excel') }}";
        if (minDate || maxDate) {
            url += '?minDate=' + minDate + '&maxDate=' + maxDate;
        }
        window.location.href = url;
    });

    $('#exportPdf').on('click', function() {
        var minDate = $('#minDate').val();
        var maxDate = $('#maxDate').val();
        var url = "{{ route('sptbs.export.pdf') }}";
        if (minDate || maxDate) {
            url += '?minDate=' + minDate + '&maxDate=' + maxDate;
        }
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
        $.get('/sptbs/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editAngkutan').val(data.angkutan);
            $('#editNoTiket').val(data.no_tiket);
            $('#editTanggalTiket').val(data.tanggal_tiket ? data.tanggal_tiket.split(' ')[0] : '');
            $('#editNoSptbs').val(data.no_sptbs);
            $('#editTanggalSptbs').val(data.tanggal_sptbs ? data.tanggal_sptbs.split(' ')[0] : '');
            $('#editTanggalPanen').val(data.tanggal_panen ? data.tanggal_panen.split(' ')[0] : '');
            $('#editNamaSupir').val(data.nama_supir);
            $('#editNoPolisi').val(data.no_polisi);
            $('#editJamMasuk').val(data.jam_masuk);
            $('#editJamKeluar').val(data.jam_keluar);
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editBlok').val(data.blok);
            $('#editTahunTanam').val(data.tahun_tanam);
            $('#editLahan').val(data.lahan);
            $('#editJumlahTandan').val(data.jumlah_tandan);
            $('#editBerondolan').val(data.berondolan);
            $('#editBeratBruto').val(data.berat_bruto);
            $('#editBeratTarra').val(data.berat_tarra);
            $('#editBeratNetto').val(data.berat_netto);
            $('#editJumlahGrading').val(data.jumlah_grading);
            $('#editBeratBersih').val(data.berat_bersih);
            $('#editBjr').val(data.bjr);
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
            url: '/sptbs/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditSptbs').modal('hide');
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
