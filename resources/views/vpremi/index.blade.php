@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Premi</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <!--<button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddSptbs" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>-->
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadPremi">
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
        <div class="table-responsive">
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
            <table id="premiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>tanggal</th>
                        <th>No KAB</th>
                        <th>Nama KAB</th>
                        <th>NIK</th>
                        <th>Nama_karyawan</th>
                        <th>Estate</th>
                        <th>HM/KM Awal</th>
                        <th>HM/KM Akhir</th>
                        <th>HM/KM Total</th>
                        <th>Lokasi</th>
                        <th>Divisi</th>
                        <th>Jenis Pekerjaan</th>
                        <th>Tarif/Satuan</th>
                        <th>Hasil 1</th>
                        <th>Satuan 1</th>
                        <th>Hasil 2</th>
                        <th>Satuan 2</th>
                        <th>Total Premi</th>
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
                <input type="time" class="form-control" id="editJamMasuk" name="jam_masuk" required>
            </div>
            <div class="form-group">
                <label for="editJamKeluar">Jam Keluar</label>
                <input type="time" class="form-control" id="editJamKeluar" name="jam_keluar" required>
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
<div class="modal fade" id="modal-UploadPremi" tabindex="-1" role="dialog" aria-labelledby="modal-UploadPremiLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadPremiLabel">Unggah Data Premi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('premi.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#premiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('premi.data') }}",
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
            { data: 'no_kab', name: 'no_kab' },
            { data: 'nama_kab', name: 'nama_kab' },
            { data: 'nik', name: 'nik' },
            { data: 'nama_karyawan', name: 'nama_karyawan' },
            { data: 'estate', name: 'estate' },
            { data: 'hmkm_awal', name: 'hmkm_awal' },
            { data: 'hmkm_akhir', name: 'hmkm_akhir' },
            { data: 'total_hmkm', name: 'total_hmkm' },
            { data: 'lokasi', name: 'lokasi' },
            { data: 'divisi', name: 'divisi' },
            { data: 'jenis_pekerjaan', name: 'jenis_pekerjaan' },
            { data: 'tarif_satuan', name: 'tarif_satuan' },
            { data: 'hasil_1', name: 'hasil_1' },
            { data: 'satuan_1', name: 'satuan_1' },
            { data: 'hasil_2', name: 'hasil_2' },
            { data: 'satuan_2', name: 'satuan_2' },
            { data: 'total_premi', name: 'total_premi' },
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
        var url = "{{ route('premi.export.excel') }}";
        if (minDate || maxDate) {
            url += '?minDate=' + minDate + '&maxDate=' + maxDate;
        }
        window.location.href = url;
    });

    $('#exportPdf').on('click', function() {
        var minDate = $('#minDate').val();
        var maxDate = $('#maxDate').val();
        var url = "{{ route('premi.export.pdf') }}";
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
        $.get('/premi/' + id + '/edit', function(data) {
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
