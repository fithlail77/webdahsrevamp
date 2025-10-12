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
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="minDate">Dari Tanggal</label>
                <input type="date" id="minDate" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="maxDate">Sampai Tanggal</label>
                <input type="date" id="maxDate" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button id="searchBtn" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
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
        <div id="noDataMessage" class="alert alert-warning mt-3" style="display:none;">
            Tidak ada data yang sesuai dengan filter tanggal.
        </div>
    </div>
</div>

<!-- Modal Edit Realisasi Panen -->
<div class="modal fade" id="modal-EditPremi" tabindex="-1" role="dialog" aria-labelledby="modal-EditPremiLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditPremiLabel">Edit Data Premi</h5>
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
                <label for="editNoKab">No KAB</label>
                <input type="text" class="form-control" id="editNoKab" name="no_kab" required>
            </div>
            <div class="form-group">
                <label for="editNamaKab">Nama KAB</label>
                <input type="text" class="form-control" id="editNamaKab" name="nama_kab" required>
            </div>
            <div class="form-group">
                <label for="editNik">NIK</label>
                <input type="text" class="form-control" id="editNik" name="nik" required>
            </div>
            <div class="form-group">
                <label for="editNamaKaryawan">Nama Karyawan</label>
                <input type="text" class="form-control" id="editNamaKaryawan" name="nama_karyawan" required>
            </div>
            <div class="form-group">
                <label for="editEstate">Estate</label>
                <input type="text" class="form-control" id="editEstate" name="estate" required>
            </div>
            <div class="form-group">
                <label for="editHmkmAwal">HM/KM Awal</label>
                <input type="text" class="form-control" id="editHmkmAwal" name="hmkm_awal" required>
            </div>
            <div class="form-group">
                <label for="editHmkmAkhir">HM/KM Akhir</label>
                <input type="text" class="form-control" id="editHmkmAkhir" name="hmkm_akhir" required>
            </div>
            <div class="form-group">
                <label for="editTotalHmkm">Total HM/KM</label>
                <input type="number" class="form-control" id="editTotalHmkm" name="total_hmkm" required>
            </div>
            <div class="form-group">
                <label for="editLokasi">Lokasi</label>
                <input type="test" class="form-control" id="editLokasi" name="lokasi" required>
            </div>
            <div class="form-group">
                <label for="editDivisi">Divisi</label>
                <input type="text" class="form-control" id="editDivisi" name="divisi" required>
            </div>
            <div class="form-group">
                <label for="editJenisPekerjaan">Jenis pekerjaan</label>
                <input type="text" class="form-control" id="editJenisPekerjaan" name="jenis_pekerjaan" required>
            </div>
            <div class="form-group">
                <label for="editTarifSatuan">Tarif</label>
                <input type="text" class="form-control" id="editTarifSatuan" name="tarif_satuan" required>
            </div>
            <div class="form-group">
                <label for="editHasil1">Hasil 1</label>
                <input type="number" class="form-control" id="editHasil1" name="hasil_1" required>
            </div>
            <div class="form-group">
                <label for="editSatuan1">Satuan 1</label>
                <input type="text" class="form-control" id="editSatuan1" name="satuan_1" required>
            </div>
            <div class="form-group">
                <label for="editHasil2">Hasil 2</label>
                <input type="number" class="form-control" id="editHasil2" name="hasil_2" required>
            </div>
            <div class="form-group">
                <label for="editSatuan2">Satuan 2</label>
                <input type="text" class="form-control" id="editSatuan2" name="satuan_2" required>
            </div>
            <div class="form-group">
                <label for="editTotalPremi">Total Premi</label>
                <input type="number" class="form-control" id="editTotalPremi" name="total_premi" required>
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
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('premi.data') }}",
            data: function(d) {
                d.minDate = $('#minDate').val();
                d.maxDate = $('#maxDate').val();
            }
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

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });

    // Handle export buttons
    $('#exportExcel').on('click', function() {
        var minDate = $('#minDate').val();
        var maxDate = $('#maxDate').val();
        var search = table.search();
        var url = "{{ route('premi.export.excel') }}";
        var params = [];
        if (minDate) params.push('minDate=' + minDate);
        if (maxDate) params.push('maxDate=' + maxDate);
        if (search) params.push('search=' + encodeURIComponent(search));
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        window.location.href = url;
    });

    $('#exportPdf').on('click', function() {
        var minDate = $('#minDate').val();
        var maxDate = $('#maxDate').val();
        var search = table.search();
        var url = "{{ route('premi.export.pdf') }}";
        var params = [];
        if (minDate) params.push('minDate=' + minDate);
        if (maxDate) params.push('maxDate=' + maxDate);
        if (search) params.push('search=' + encodeURIComponent(search));
        if (params.length > 0) {
            url += '?' + params.join('&');
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
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editNoKab').val(data.no_kab);
            $('#editNamaKab').val(data.nama_kab);
            $('#editNik').val(data.nik);
            $('#editNamaKaryawan').val(data.nama_karyawan);
            $('#editEstate').val(data.estate);
            $('#editHmkmAwal').val(data.hmkm_awal);
            $('#editHmkmAkhir').val(data.hmkm_akhir);
            $('#editTotalHmkm').val(data.total_hmkm);
            $('#editLokasi').val(data.lokasi);
            $('#editDivisi').val(data.divisi);
            $('#editJenisPekerjaan').val(data.jenis_pekerjaan);
            $('#editTarifSatuan').val(data.tarif_satuan);
            $('#editHasil1').val(data.hasil_1);
            $('#editSatuan1').val(data.satuan_1);
            $('#editHasil2').val(data.hasil_2);
            $('#editSatuan2').val(data.satuan_2);
            $('#editTotalPremi').val(data.total_premi);
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
            url: '/premi/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditPremi').modal('hide');
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
