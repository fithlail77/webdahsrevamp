@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Produksi PKS</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <!--<button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>-->
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadCPO" align="right">
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
      <div class="card-header">Grafik Produksi CPO -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="CPOChart" width="100%" height="25"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card mb-2">
      <div class="card-header">Grafik Produksi Kernel -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="PKChart" width="100%" height="25"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
</div>-->
<div class="card shadow mb-4">
    <div class="card-body">
        <table id="produksicpoTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>TBS Internal</th>
                    <th>% Internal</th>
                    <th>TBS Eksternal</th>
                    <th>% Eksternal</th>
                    <th>Total TBS</th>
                    <th>Total TBS Olah</th>
                    <th>Sisa</th>
                    <th>CPO Today</th>
                    <th>CPO Todate</th>
                    <th>Kernel</th>
                    <th>OER</th>
                    <th>KER</th>
                    <th>Oil Loss</th>
                    <th>Kernel Loss</th>
                    <th>Stok Tangki 1</th>
                    <th>Stok Tangki 2</th>
                    <th>Stok Jetty</th>
                    <th>Despatch Jetty</th>
                    <th>Despatch Tongkang</th>
                    <th>Kernel Silo 1</th>
                    <th>Kernel Silo 2</th>
                    <th>Kernel Gudang</th>
                    <th>Kernel Station</th>
                    <th>Kernel Workshop</th>
                    <th>Kernel St Despatch</th>
                    <th>Kernel Bulking Silo</th>
                    <th>Stok Kernel Total</th>
                    <th>Despatch Kernel</th>
                    <th>Cangkang</th>
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
<div class="modal fade" id="modal-UploadCPO" tabindex="-1" role="dialog" aria-labelledby="modal-UploadCPOLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadCPOLabel">Unggah Produksi CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('produksicpo.import') }}" method="POST" enctype="multipart/form-data">
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
<!-- Modal Edit Contract CPO -->
<div class="modal fade" id="modal-EditProduksiCpo" tabindex="-1" role="dialog" aria-labelledby="modal-EditFProduksiCpoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditProduksiCpoLabel">Ubah Data Produksi Harian PKS</h5>
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
                <input type="date" class="form-control" id="editTanggal" name="tanggal" disabled>
            </div>
            <div class="form-group">
                <label for="editTbsInt">TBS Internal</label>
                <input type="number" class="form-control" id="editTbsInt" name="tbs_terima_internal">
            </div>
            <div class="form-group">
                <label for="editPersenInt">Persen TBS Internal</label>
                <input type="number" step="0.01" class="form-control" id="editPersenInt" name="persen_terima_internal" >
            </div>
            <div class="form-group">
                <label for="editTbsEks">TBS Eksternal</label>
              <input type="number" class="form-control" id="editTbsEks" name="tbs_terima_eksternal" >
            </div>
            <div class="form-group">
                <label for="PersenEks">Persen TBS Eksternal</label>
                <input type="number" step='0.01' class="form-control" id="PersenEks" name="" >
            </div>
            <div class="form-group">
                <label for="editTotalTbs">Total TBS</label>
                <input type="number" class="form-control" id="editTotalTbs" name="total_terima_tbs" >
            </div>
            <div class="form-group">
                <label for="editTbsOlah">Total TBS Olah</label>
                <input type="number" class="form-control" id="editTbsOlah" name="tbs_olah" >
            </div>
            <div class="form-group">
                <label for="editSisa">Sisa</label>
                <input type="date" class="form-control" id="editSisa" name="sisa">
            </div>
            <div class="form-group">
                <label for="editCpoToday">CPO Today</label>
                <input type="number" class="form-control" id="editCpoToday" name="cpo_produksi_today">
            </div>
            <div class="form-group">
                <label for="editCpoTodate">CPO Todate</label>
                <input type="number" class="form-control" id="editCpoTodate" name="cpo_produksi_todate">
            </div>
            <div class="form-group">
                <label for="editKernel">Kernel</label>
                <input type="number" class="form-control" id="editKernel" name="kernel_produksi">
            </div>
            <div class="form-group">
                <label for="editOer">OER</label>
                <input type="number" step="0.01" class="form-control" id="editOer" name="oer">
            </div>
            <div class="form-group">
                <label for="editKer">KER</label>
                <input type="number" step="0.01" class="form-control" id="editKer" name="ker">
            </div>
            <div class="form-group">
                <label for="editOilLoss">Oil Loss</label>
                <input type="number" step="0.01" class="form-control" id="editOilLoss" name="oil_loss">
            </div>
            <div class="form-group">
                <label for="editKernelLoss">Kernel Loss</label>
                <input type="number" step="0.01" class="form-control" id="editKernelLoss" name="kernel_loss">
            </div>
            <div class="form-group">
                <label for="editTangki1">Stok Tangki 1 CPO</label>
                <input type="number" class="form-control" id="editTangki1" name="stok_cpo_pks_1">
            </div>
            <div class="form-group">
                <label for="editTangki2">Stok Tangki 2 CPO</label>
                <input type="number" class="form-control" id="editTangki2" name="stok_cpo_pks_2">
            </div>
            <div class="form-group">
                <label for="editJetty">Stok Jetty CPO</label>
                <input type="number" class="form-control" id="editJetty" name="stok_cpo_jetty_1">
            </div>
            <div class="form-group">
                <label for="editDespatchJetty">Despatch Jetty</label>
                <input type="number" class="form-control" id="editDespatchJetty" name="cpo_despatch_jetty">
            </div>
            <div class="form-group">
                <label for="editDespatchTongkang">Despatch Tongkang</label>
                <input type="number" class="form-control" id="editDespatchTongkang" name="cpo_despatch_tongkang">
            </div>
            <div class="form-group">
                <label for="editSilo1">Kernel Silo 1</label>
                <input type="number" class="form-control" id="editSilo1" name="stok_kernel_sistem_proses_silo_1">
            </div>
            <div class="form-group">
                <label for="editSilo2">Kernel Silo 2</label>
                <input type="number" class="form-control" id="editSilo2" name="stok_kernel_sistem_proses_silo_2">
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
    var table = $('#produksicpoTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('produksicpo.data') }}",
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
            { data: 'tbs_terima_internal', name: 'tbs_terima_internal' },
            { data: 'persen_terima_internal', name: 'persen_terima_internal' },
            { data: 'tbs_terima_eksternal', name: 'tbs_terima_eksternal' },
            { data: 'persen_terima_eksternal', name: 'persen_terima_eksternal' },
            { data: 'total_tbs_terima', name: 'total_tbs_terima' },
            { data: 'tbs_olah', name: 'tbs_olah' },
            { data: 'sisa', name: 'sisa' },
            { data: 'cpo_produksi_today', name: 'cpo_produksi_today' },
            { data: 'cpo_produksi_todate', name: 'cpo_produksi_todate' },
            { data: 'kernel_produksi', name: 'kernel_produksi' },
            { data: 'oer', name: 'oer'},
            { data: 'ker', name: 'ker' },
            { data: 'oil_loss', name: 'oil_loss' },
            { data: 'kernel_loss', name: 'kernel_loss' },
            { data: 'stok_cpo_pks_1', name: 'stok_cpo_pks_1' },
            { data: 'stok_cpo_pks_2', name: 'stok_cpo_pks_2' },
            { data: 'stok_cpo_jetty_1', name: 'stok_cpo_jetty_1' },
            { data: 'cpo_despatch_jetty', name: 'cpo_despatch_jetty' },
            { data: 'cpo_despatch_tongkang', name: 'cpo_despatch_tongkang' },
            { data: 'stok_kernel_sistem_proses_silo_1', name: 'stok_kernel_sistem_proses_silo_1' },
            { data: 'stok_kernel_sistem_proses_silo_2', name: 'stok_kernel_sistem_proses_silo_2' },
            { data: 'stok_kernel_gudang', name: 'stok_kernel_gudang' },
            { data: 'stok_kernel_st_kernel', name: 'stok_kernel_st_kernel' },
            { data: 'stok_kernel_depan_workshop', name: 'stok_kernel_depan_workshop' },
            { data: 'stok_kernel_st_despatch', name: 'stok_kernel_st_despatch' },
            { data: 'stok_kernel_bulking_silo', name: 'stok_kernel_bulking_silo' },
            { data: 'stok_kernel_total', name: 'stok_kernel_total' },
            { data: 'despatch_kernel', name: 'despatch_kernel' },
            { data: 'stok_cangkang', name: 'stok_cangkang' },
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
        var url = "{{ route('produksicpo.export.excel') }}";
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
        var url = "{{ route('produksicpo.export.pdf') }}";
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
        const ctx1 = document.getElementById('CPOChart').getContext('2d');
        const CPOChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'Produksi CPO Bulan Ini',
                    data: @json($chart1),
                    backgroundColor: 'rgba(254, 114, 67, 1)',
                    borderColor: 'rgba(254, 114, 67, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value != null ? value.toLocaleString() : '';
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
                              return value != null ? value.toLocaleString() : ''; // Format ribuan untuk sumbu Y
                            }
                        },
                        title: {
                            display: true,
                            text: 'Ton'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
</script>

<script>
        const ctx2 = document.getElementById('PKChart').getContext('2d');
        const PKChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'Produksi CPO Bulan Ini',
                    data: @json($chart2),
                    backgroundColor: 'rgba(0, 0, 0, 1)',
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value != null ? value.toLocaleString() : '';
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
                              return value != null ? value.toLocaleString() : ''; // Format ribuan untuk sumbu Y
                            }
                        },
                        title: {
                            display: true,
                            text: 'Ton'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
</script> -->
@endpush