@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">FFB Internal</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddFFBInt" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadFfbInt" align="right">
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
        <div class="row mb-1">
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
<!--<div class="card shadow mb-4">

    <div class="card mb-2">
      <div class="card-header">Grafik TBS Internal GUM -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="FfbIntChart" width="100%" height="50"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
</div>-->
<div class="card shadow mb-4">
    <div class="card-body">
        <table id="ffbintTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                  <th>No</th>
                  <th>No PO</th>
                  <th>Vendor Detail</th>
                  <th>Vendor Group</th>
                  <th>Vendor Transportir</th>
                  <th>Tgl</th>
                  <th>Bln</th>
                  <th>Thn</th>
                  <th>Tanggal</th>
                  <th>Jam Masuk</th>
                  <th>Jam Keluar</th>
                  <th>Plat Kenderaan</th>
                  <th>Supir</th>
                  <th>Bruto Awal</th>
                  <th>Tarra</th>
                  <th>Ton Bruto</th>
                  <th>Grading</th>
                  <th>Netto</th>
                  <th>Janjang</th>
                  <th>BJR</th>
                  <th>Area</th>
                  <th>Umur Tanaman</th>
                  <th>Bulan</th>
                  <th>Estate</th>
                  <th>Divisi</th>
                  <th>Asal TBS</th>
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

<!-- Modal File Upload -->
<div class="modal fade" id="modal-UploadFfbInt" tabindex="-1" role="dialog" aria-labelledby="modal-UploadFfbIntLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadFfbIntLabel">Unggah Data TBS Internal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('ffbinternal.import') }}" method="POST" enctype="multipart/form-data">
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
<!-- Modal Tambah Data Penerimaan FFB Int PKS -->
<div class="modal fade" id="modal-AddFFBInt" tabindex="-1" role="dialog" aria-labelledby="modal-AddFFBIntLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddFFBIntLabel">Tambah Data Penerimaan FFB Internal PKS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('ffbinternal.simpan') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">No PO</label>
                        <input class="form-control" name="no_po" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Vendor Detail</label>
                        <input class="form-control" name="vendor_detail" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Vendor Group</label>
                        <input class="form-control" name="vendor_group" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Vendor Transportir</label>
                        <input class="form-control" name="vendor_transportir" type="text"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal SPTBS</label>
                        <input class="form-control" name="tglsptbs" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Panen</label>
                        <input class="form-control" name="tglpanen" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nama Supir</label>
                        <input class="form-control" name="supir" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">No Polisi</label></label>
                        <input class="form-control" name="nopol" type="text" />
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Jam Masuk</label>
                        <input class="form-control" name="timein" type="time" step="1"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jam Keluar</label>
                        <input class="form-control" name="timeout" type="time" step="1"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Estate</label>
                        <select class="form-control" name="estate">
                            <option value="">-- Pilih --</option>
                            @foreach($estate as $item)
                                <option value="{{ $item->estate }}">{{ $item->estate }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Divisi</label>
                        <select class="form-control" name="divisi">
                            <option value="">-- Pilih --</option>
                            @foreach($divisi as $item)
                                <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Blok</label>
                        <input class="form-control" name="blok" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tahun Tanam</label>
                        <input class="form-control" name="tahuntanam" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Inti/Plasma</label>
                        <select class="form-control" name="lahan">
                            <option value="">-- Pilih --</option>
                            <option value="Inti">Inti</option></option>
                            <option value="Plasma">Plasma</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah Tandan</label></label>
                        <input class="form-control" name="jmltandan" type="number" />
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Berondolan</label>
                        <input class="form-control" name="berondolan" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Bruto</label>
                        <input class="form-control" name="bruto" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Tarra</label>
                        <input class="form-control" name="tarra" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Netto</label></label>
                        <input class="form-control" name="netto" type="number" />
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah Grading</label>
                        <input class="form-control" name="grading" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Bersih</label>
                        <input class="form-control" name="bersih" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">BJR</label>
                        <input class="form-control" name="bjr" id="bjr" type="number" step="0.01"/>
                    </div>
                </div>
                <hr>
                <label class="small mb-1">Grading (Kg)</label>
                <hr>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">F-O0</label>
                        <input class="form-control" name="f00" id="f00" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">F-0</label>
                        <input class="form-control" name="f0" id="f0" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">F1 s.d F4</label>
                        <input class="form-control" name="f14" id="f14" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">F5</label>
                        <input class="form-control" name="f5" id="f5" type="number" step="0.01"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">F6</label>
                        <input class="form-control" name="f6" id="f6" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tandan Kosong</label>
                        <input class="form-control" name="tankos" id="t_kosong" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Sampah</label>
                        <input class="form-control" name="sampah" id="sampah" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tangkai Pjg</label>
                        <input class="form-control" name="tangkai_pjg" id="tangkai_pjg" type="number" step="0.01"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Kastrasi</label>
                        <input class="form-control" name="kastrasi" id="kastrasi" type="number" step="0.01"/>
                    </div>
                </div>
            </div>
            <div class="text-right mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit FFB Internal -->
<div class="modal fade" id="modal-EditFfbInternal" tabindex="-1" role="dialog" aria-labelledby="modal-EditFfbInternalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditFfbInternalLabel">Ubah Data Tiket Timbangan TBS Internal</h5>
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
                <label for="editNoTiket">No Tiket</label>
                <input type="number" class="form-control" id="editNoTiket" name="no_po">
            </div>
            <div class="form-group">
                <label for="editVendor">Vendor Detail</label>
                <input type="text" class="form-control" id="editVendor" name="vendor_detail">
            </div>
            <div class="form-group">
                <label for="editVendorGroup">Vendor Group</label>
                <input type="text" class="form-control" id="editVendorGroup" name="vendor_group" >
            </div>
            <div class="form-group">
                <label for="editVendorTransportir">Vendor Transportir</label>
                <input type="text" class="form-control" id="editVendorTransportir" name="vendor_transportir" >
            </div>
            <div class="form-group">
                <label for="editTgl">Tgl</label>
                <input type="number" class="form-control" id="editTgl" name="tgl" >
            </div>
            <div class="form-group">
                <label for="editBln">Bln</label>
                <input type="number" class="form-control" id="editBln" name="bln" >
            </div>
            <div class="form-group">
                <label for="editThn">Thn</label>
                <input type="number" class="form-control" id="editThn" name="thn" >
            </div>
            <div class="form-group">
                <label for="editTanggal">Tanggal</label>
                <input type="date" class="form-control" id="editTanggal" name="tanggal">
            </div>
            <div class="form-group">
                <label for="editJamMasuk">Jam Masuk (HH:MM:SS)</label>
                <input type="time" step="1" class="form-control" id="editJamMasuk" name="time_in">
            </div>
            <div class="form-group">
                <label for="editJamKeluar">Jam Keluar (HH:MM:SS)</label>
                <input type="time" step="1" class="form-control" id="editJamKeluar" name="time_out">
            </div>
            <div class="form-group">
                <label for="editPlat">Plat Kenderaan</label>
                <input type="text" class="form-control" id="editPlat" name="no_plat">
            </div>
            <div class="form-group">
                <label for="editDriver">Nama Supir</label>
                <input type="text" class="form-control" id="editDriver" name="driver">
            </div>
            <div class="form-group">
                <label for="editBruto">Bruto</label>
                <input type="number" class="form-control" id="editBruto" name="bruto_awal">
            </div>
            <div class="form-group">
                <label for="editTarra">Tarra</label>
                <input type="number" class="form-control" id="editTarra" name="tarra">
            </div>
            <div class="form-group">
                <label for="editTonBruto">Ton Bruto</label>
                <input type="number" class="form-control" id="editTonBruto" name="ton_bruto">
            </div>
            <div class="form-group">
                <label for="editGrading">Grading</label>
                <input type="number" class="form-control" id="editGrading" name="grading">
            </div>
            <div class="form-group">
                <label for="editNetto">Ton Netto</label>
                <input type="number" class="form-control" id="editNetto" name="netto">
            </div>
            <div class="form-group">
                <label for="editJanjang">Janjang</label>
                <input type="number" class="form-control" id="editJanjang" name="jml_tandan">
            </div>
            <div class="form-group">
                <label for="editBjr">BJR</label>
                <input type="number" step="0.01" class="form-control" id="editBjr" name="bjr">
            </div>
            <div class="form-group">
                <label for="editArea">Area</label>
                <input type="text" class="form-control" id="editArea" name="area">
            </div>
            <div class="form-group">
                <label for="editUmurTanaman">Umur Tanaman</label>
                <input type="number" class="form-control" id="editUmurTanaman" name="umur_tanaman">
            </div>
            <div class="form-group">
                <label for="editBulan">Bulan</label>
                <input type="date" class="form-control" id="editBulan" name="bulan">
            </div>
            <div class="form-group">
                <label for="editEstate">Estate</label>
                <input type="text" class="form-control" id="editEstate" name="estate">
            </div>
            <div class="form-group">
                <label for="editDivisi">Divisi</label>
                <input type="number" class="form-control" id="editDivisi" name="divisi">
            </div>
            <div class="form-group">
                <label for="editAsalTbs">Asal TBS</label>
                <input type="text" class="form-control" id="editAsalTbs" name="asal_tbs">
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
<style>
    .dt-nowrap {
        white-space: nowrap;
    }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#ffbintTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('ffbinternal.data') }}",
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
            { data: 'no_po', name: 'no_po' },
            { data: 'vendor_detail', name: 'vendor_detail' },
            { data: 'vendor_group', name: 'vendor_group' },
            { data: 'vendor_transportir', name: 'vendor_transportir' },
            { data: 'tgl', name: 'tgl' },
            { data: 'bln', name: 'bln' },
            { data: 'thn', name: 'thn' },
            { data: 'tanggal_formatted', name: 'tanggal_formatted' },
            { data: 'time_in', name: 'time_in' },
            { data: 'time_out', name: 'time_out' },
            { data: 'no_plat', name: 'no_plat'},
            { data: 'driver', name: 'driver' },
            { data: 'bruto_awal', name: 'bruto_awal' },
            { data: 'tarra', name: 'tarra' },
            { data: 'ton_bruto', name: 'ton_bruto' },
            { data: 'grading', name: 'grading' },
            { data: 'netto', name: 'netto' },
            { data: 'jml_tandan', name: 'jml_tandan' },
            { data: 'bjr', name: 'bjr' },
            { data: 'area', name: 'area' },
            { data: 'umur_tanaman', name: 'umur_tanaman' },
            { data: 'tanggal_formatted1', name: 'tanggal_formatted1' },
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'asal_tbs', name: 'asal_tbs' },
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
        var url = "{{ route('ffbinternal.export.excel') }}";
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
        var url = "{{ route('ffbinternal.export.pdf') }}";
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
        $.get('/ffbinternal/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editNoTiket').val(data.no_po);
            $('#editVendor').val(data.vendor_detail);
            $('#editVendorGroup').val(data.vendor_group);
            $('#editVendorTransportir').val(data.vendor_transportir);
            $('#editTgl').val(data.tgl);
            $('#editBln').val(data.bln);
            $('#editThn').val(data.thn);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editJamMasuk').val(data.time_in);
            $('#editJamKeluar').val(data.time_out);
            $('#editPlat').val(data.no_plat);
            $('#editDriver').val(data.driver);
            $('#editBruto').val(data.bruto_awal);
            $('#editTarra').val(data.tarra);
            $('#editTonBruto').val(data.ton_bruto);
            $('#editGrading').val(data.grading);
            $('#editNetto').val(data.netto);
            $('#editJanjang').val(data.jml_tandan);
            $('#editBjr').val(data.bjr);
            $('#editArea').val(data.area);
            $('#editUmurTanaman').val(data.umur_tanaman);
            $('#editBulan').val(data.bulan ? data.bulan.split(' ')[0] : '');
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editAsalTbs').val(data.asal_tbs);
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
            url: '/ffbinternal/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditFfbInternal').modal('hide');
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
<!--<script>
        const ctx1 = document.getElementById('FfbIntChart').getContext('2d');
        const FfbIntChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Ton Bruto',
                    data:,
                     backgroundColor: 'rgba(154, 200, 243, 1)',
                    borderColor: 'rgba(154, 200, 243, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value.toLocaleString('en-US');
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision:0,
                            callback: function(value) {
                              return value.toLocaleString('en-US'); // Format ribuan untuk sumbu Y
                            }
                        },
                        title: {
                            display: true,
                            text: 'Ton Bruto'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
</script>-->
<!--<script>
const ctx1 = document.getElementById('FfbIntChart').getContext('2d');
const grading = @json($grading);

const FfbIntChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'Ton Bruto',
                data: @json($bruto),
                backgroundColor: @json(array_map(fn($val) => $val >= $target ? '#B0E6B2' : '#F38383', $bruto)),
                borderColor: 'rgba(0,0,0,0.2)',
                borderWidth: 1,
                barThickness: 25, // Menambah lebar batang
                datalabels: {
                    align: 'start',
                    anchor: 'end',
                    offset: 2,
                    padding: {
                        top: 2
                    },
                    formatter: (value, context) => {
                        const idx = context.dataIndex;
                        const percent = grading[idx] ?? 0;
                        return value > 0 ? `${value.toLocaleString()}\n(${percent}%)` : '';
                    },
                    color: '#880E4F',
                    font: { weight: 'bold', size: 9 }
                }
            },
            {
                label: 'Ton Netto (Grading %)',
                data: @json($grading),
                type: 'bar',
                backgroundColor: 'rgba(0,0,0,0)',
                barThickness: 20,
                datalabels: {
                    display: false // disembunyikan karena sudah ditampilkan di batang Ton Bruto
                }
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            datalabels: {
                clip: true
            },
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Ton Bruto Bulan Ini'
            },
            annotation: {
                annotations: {
                    line1: {
                        type: 'line',
                        yMin: {{ $target }},
                        yMax: {{ $target }},
                        borderColor: 'rgba(0, 180, 216, 0.8)',
                        borderWidth: 2,
                        borderDash: [6, 6],
                        label: {
                            content: 'Target/Hari: {{ $target }}',
                            enabled: true,
                            position: 'end',
                            color: '#008CBA',
                            font: { weight: 'bold' }
                        }
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => value.toLocaleString(undefined, {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                        })
                    },
                title: {
                    display: true,
                    text: 'Ton Bruto'
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
</script>-->
@endpush