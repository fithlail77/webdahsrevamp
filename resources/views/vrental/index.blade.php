@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Realisasi Rental Kenderaan & Alat Berat</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <!--<button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddSptbs" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>-->
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadRental">
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
            <table id="rentalTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Estate</th>
                        <th>Jenis Alat</th>
                        <th>Nomor Alat</th>
                        <th>Operator</th>
                        <th>HM Awal</th>
                        <th>HM Akhir</th>
                        <th>Total HM</th>
                        <th>Potongan HM</th>
                        <th>Pembayaran HM</th>
                        <th>Blok</th>
                        <th>Tahun Tanam</th>
                        <th>Pekerjaan</th>
                        <th>Divisi</th>
                        <th>Kelompok</th>
                        <th>COA</th>
                        <th>Tarif</th>
                        <th>BJR</th>
                        <th>Hasil 1</th>
                        <th>SAtuan 1</th>
                        <th>Hasil 2</th>
                        <th>Satuan 2</th>
                        <th>Total Biaya</th>
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
<div class="modal fade" id="modal-EditRental" tabindex="-1" role="dialog" aria-labelledby="modal-EditRentalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditRentalLabel">Edit Data  Rental KAB</h5>
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
                <label for="editEstate">Estate</label>
                <input type="text" class="form-control" id="editEstate" name="estate" required>
            </div>
            <div class="form-group">
                <label for="editJenisAlat">Jenis Alat</label>
                <input type="text" class="form-control" id="editJenisAlat" name="jenis_alat" required>
            </div>
            <div class="form-group">
                <label for="editNoAlat">Nomor Alat</label>
                <input type="text" class="form-control" id="editNoAlat" name="no_alat" required>
            </div>
            <div class="form-group">
                <label for="editOperator">Operator</label>
                <input type="text" class="form-control" id="editOperator" name="operator" required>
            </div>
            <div class="form-group">
                <label for="editHmAwal">HM Awal</label>
                <input type="number" class="form-control" id="editHmAwal" name="hm_awal" required>
            </div>
            <div class="form-group">
                <label for="editHmAkhir">HM Akhir</label>
                <input type="number" step="0.01" class="form-control" id="editHmAkhir" name="hm_akhir" required>
            </div>
            <div class="form-group">
                <label for="editTotalHm">Total HM</label>
                <input type="number" step="0.01" class="form-control" id="editTotalHm" name="total_hm" required>
            </div>
            <div class="form-group">
                <label for="editPotonganHm">Potongan HM</label>
                <input type="number" step="0.01" class="form-control" id="editPotonganHm" name="potongan_hm" required>
            </div>
            <div class="form-group">
                <label for="editPembayaranHm">Pembayaran HM</label>
                <input type="number" step="0.01" class="form-control" id="editPembayaranHm" name="pembayaran_hm" required>
            </div>
            <div class="form-group">
                <label for="editBlok">Blok</label>
                <input type="text" class="form-control" id="editBlok" name="blok" required>
            </div>
            <div class="form-group">
                <label for="editTahunTanam">Tahun Tanam</label>
                <input type="number" class="form-control" id="editTahunTanam" name="tahun_tanam" required>
            </div>
            <div class="form-group">
                <label for="editPekerjaan">Pekerjaan</label>
                <input type="text" class="form-control" id="editPekerjaan" name="pekerjaan" required>
            </div>
            <div class="form-group">
                <label for="editDivisi">Divisi</label>
                <input type="text" class="form-control" id="editDivisi" name="divisi" required>
            </div>
            <div class="form-group">
                <label for="editKelompok">Kelompok</label>
                <input type="text" class="form-control" id="editKelompok" name="kelompok" required>
            </div>
            <div class="form-group">
                <label for="editCoa">COA</label>
                <input type="number" class="form-control" id="editCoa" name="coa" required>
            </div>
            <div class="form-group">
                <label for="editTarif">Tarif</label>
                <input type="number" class="form-control" id="editTarif" name="tarif" required>
            </div>
            <div class="form-group">
                <label for="editBjr">BJR</label>
                <input type="number" step="0.01" class="form-control" id="editBjr" name="bjr" required>
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
                <label for="editTotalBiaya">Total Biaya</label>
                <input type="number" class="form-control" id="editTotalBiaya" name="total_biaya" required>
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
<div class="modal fade" id="modal-UploadRental" tabindex="-1" role="dialog" aria-labelledby="modal-UploadRentalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadRentalLabel">Unggah Data Realisasi Rental Kenderaan dan Alat Berat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('rental.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#rentalTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('rental.data') }}",
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
            { data: 'estate', name: 'estate' },
            { data: 'jenis_alat', name: 'jenis_alat' },
            { data: 'no_alat', name: 'no_alat' },
            { data: 'operator', name: 'operator' },
            { data: 'hm_awal', name: 'hm_awal' },
            { data: 'hm_akhir', name: 'hm_akhir' },
            { data: 'total_hm', name: 'total_hm' },
            { data: 'potongan_hm', name: 'potongan_hm' },
            { data: 'pembayaran_hm', name: 'pembayaran_hm' },
            { data: 'blok', name: 'blok' },
            { data: 'tahun_tanam', name: 'tahun_tanam' },
            { data: 'pekerjaan', name: 'pekerjaan' },
            { data: 'divisi', name: 'divisi' },
            { data: 'kelompok', name: 'kelompok' },
            { data: 'coa', name: 'coa' },
            { data: 'tarif', name: 'tarif' },
            { data: 'bjr', name: 'bjr' },
            { data: 'hasil_1', name: 'hasil_1' },
            { data: 'satuan_1', name: 'satuan_1' },
            { data: 'hasil_2', name: 'hasil_2' },
            { data: 'satuan_2', name: 'satuan_2' },
            { data: 'total_biaya', name: 'total_biaya' },
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
        var url = "{{ route('rental.export.excel') }}";
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
        var url = "{{ route('rental.export.pdf') }}";
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
        $.get('/rental/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editEstate').val(data.estate);
            $('#editJenisAlat').val(data.jenis_alat);
            $('#editNoAlat').val(data.no_alat);
            $('#editOperator').val(data.operator);
            $('#editHmAwal').val(data.hm_awal);
            $('#editHmAkhir').val(data.hm_akhir);
            $('#editTotalHm').val(data.total_hm);
            $('#editPotonganHm').val(data.potongan_hm);
            $('#editPembayaranHm').val(data.pembayaran_hm);
            $('#editBlok').val(data.blok);
            $('#editTahunTanam').val(data.tahun_tanam);
            $('#editPekerjaan').val(data.pekerjaan);
            $('#editDivisi').val(data.divisi);
            $('#editKelompok').val(data.kelompok);
            $('#editCoa').val(data.coa);
            $('#editTarif').val(data.tarif);
            $('#editBjr').val(data.bjr);
            $('#editHasil1').val(data.hasil_1);
            $('#editSatuan1').val(data.satuan_1);
            $('#editHasil2').val(data.hasil_2);
            $('#editSatuan2').val(data.satuan_2);
            $('#editTotalBiaya').val(data.total_biaya);
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
            url: '/rental/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditRental').modal('hide');
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
