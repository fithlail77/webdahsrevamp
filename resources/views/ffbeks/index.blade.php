@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">FFB Eksternal</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <!--<button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>-->
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadFfbEks" align="right">
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
      <div class="card-header">Grafik TBS Eksternal GUM -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="FfbEksChart" width="100%" height="25"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
</div>-->
<div class="card shadow mb-4">
    <div class="card-body">
        <table id="ffbeksTable" class="table table-bordered table-striped">
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
<div class="modal fade" id="modal-UploadFfbEks" tabindex="-1" role="dialog" aria-labelledby="modal-UploadFfbEksLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadFfbEksLabel">Unggah Data TBS Eksternal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('ffbeksternal.import') }}" method="POST" enctype="multipart/form-data">
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
<!-- Modal Edit FFB Eksternal -->
<div class="modal fade" id="modal-EditFfbEksternal" tabindex="-1" role="dialog" aria-labelledby="modal-EditFfbEksternalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditFfbEksternalLabel">Ubah Data Tiket Timbangan TBS Internal</h5>
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
                <input type="text" class="form-control" id="editDivisi" name="divisi">
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
    var table = $('#ffbeksTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('ffbeksternal.data') }}",
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
        var url = "{{ route('ffbeksternal.export.excel') }}";
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
        var url = "{{ route('ffbeksternal.export.pdf') }}";
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
        $.get('/ffbeksternal/' + id + '/edit', function(data) {
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
            url: '/ffbeksternal/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditFfbEksternal').modal('hide');
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
        const ctx1 = document.getElementById('FfbEksChart').getContext('2d');
        const FfbEksChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'FFB Eksternal',
                    data: @json($data),
                    backgroundColor: 'rgba(58, 172, 74, 1)',
                    borderColor: 'rgba(58, 172, 74, 1)',
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
@endpush