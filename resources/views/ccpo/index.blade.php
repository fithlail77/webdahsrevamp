@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Penjualan CPO</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddCCPO" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadCCPO" align="right">
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
        <table id="ccpoTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>GGU SC</th>
                    <th>GUM SC</th>
                    <th>Tanggal Plan Loading</th>
                    <th>Tanggal Real Loading</th>
                    <th>Tanggal BA Loading</th>
                    <th>Tanggal Pricing</th>
                    <th>Harga</th>
                    <th>Nilai Penjualan</th>
                    <th>Kuantiti Kontrak</th>
                    <th>Kuantiti Real</th>
                    <th>Armada</th>
                    <th>Suhu</th>
                    <th>Pembeli</th>
                    <th>Status</th>
                    <th>Hari Loading</th>
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
<div class="modal fade" id="modal-UploadCCPO" tabindex="-1" role="dialog" aria-labelledby="modal-UploadCCPOLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadCCPOLabel">Unggah Kontrak CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('contractcpo.import') }}" method="POST" enctype="multipart/form-data">
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
<!-- Modal Tambah Data Contract CPO -->
<div class="modal fade" id="modal-AddCCPO" tabindex="-1" role="dialog" aria-labelledby="modal-AddCCPOLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddCCPOLabel">Tambah Data Kontrak CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('contractcpo.simpan') }}" method="POST">
            @csrf
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">GGU SC</label>
                        <input class="form-control" name="ggu_sc" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">GUM SC</label>
                        <input class="form-control" name="gum_sc" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Plan Loading</label>
                        <input class="form-control"  name="plan_loading_tk" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Real Loading</label>
                        <input class="form-control" name="real_loading_tk" type="date" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal BA Loading</label>
                        <input class="form-control" name="tgl_ba_loading_tk" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Pricing</label>
                        <input class="form-control" name="tgl_pricing" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Harga</label>
                        <input class="form-control"  name="real_price" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nilai Penjualan</label>
                        <input class="form-control" name="nilai_penjualan" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Kontrak (Ton)</label>
                        <input class="form-control" name="kontrak_qty_ton" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Real (Kg)</label>
                        <input class="form-control" name="real_qty_kg" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Armada</label>
                        <input class="form-control" name="kapal_tongkang" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Suhu</label>
                        <input class="form-control" name="suhu" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Pembeli</label>
                        <input class="form-control" name="buyer" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Status</label>
                        <input class="form-control" name="status" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Lama Loading (Hari)</label>
                        <input class="form-control" name="lama_loading_hari" type="number" required/>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Data Contract CPO -->
<div class="modal fade" id="modal-EditCcpo" tabindex="-1" role="dialog" aria-labelledby="modal-EditCcpoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditCcpoLabel">Ubah Data Kontrak CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editId" name="id">
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">GGU SC</label>
                        <input class="form-control" id="editGguSc" name="ggu_sc" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">GUM SC</label>
                        <input class="form-control" id="editGumSc" name="gum_sc" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Plan Loading</label>
                        <input class="form-control" id="editPlanLoadingTk" name="plan_loading_tk" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Real Loading</label>
                        <input class="form-control" id="editRealLoadingTk" name="real_loading_tk" type="date" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal BA Loading</label>
                        <input class="form-control" id="editTglBaLoadingTk" name="tgl_ba_loading_tk" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Pricing</label>
                        <input class="form-control" id="editTglPricing" name="tgl_pricing" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Harga</label>
                        <input class="form-control" id="editRealPrice" name="real_price" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nilai Penjualan</label>
                        <input class="form-control" id="editNilaiPenjualan" name="nilai_penjualan" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Kontrak (Ton)</label>
                        <input class="form-control" id="editKontrakQtyTon" name="kontrak_qty_ton" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Real (Kg)</label>
                        <input class="form-control" id="editRealQtyKg" name="real_qty_kg" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Armada</label>
                        <input class="form-control" id="editKapalTongkang" name="kapal_tongkang" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Suhu</label>
                        <input class="form-control" id="editSuhu" name="suhu" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Pembeli</label>
                        <input class="form-control" id="editBuyer" name="buyer" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Status</label>
                        <input class="form-control" id="editStatus" name="status" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Lama Loading (Hari)</label>
                        <input class="form-control" id="editLamaLoadingHari" name="lama_loading_hari" type="number" required/>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
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
    var table = $('#ccpoTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('contractcpo.data') }}",
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
            { data: 'ggu_sc', name: 'ggu_sc'},
            { data: 'gum_sc', name: 'gum_sc'},
            { data: 'tanggal_formatted1', name: 'tanggal_formatted1' },
            { data: 'tanggal_formatted2', name: 'tanggal_formatted2' },
            { data: 'tanggal_formatted3', name: 'tanggal_formatted3' },
            { data: 'tanggal_formatted4', name: 'tanggal_formatted4' },
            { data: 'real_price', name: 'real_price' },
            { data: 'nilai_penjualan', name: 'nilai_penjualan' },
            { data: 'kontrak_qty_ton', name: 'kontrak_qty_ton' },
            { data: 'real_qty_kg', name: 'real_qty_kg' },
            { data: 'kapal_tongkang', name: 'kapal_tongkang' },
            { data: 'suhu', name: 'suhu' },
            { data: 'buyer', name: 'buyer' },
            { data: 'status', name: 'status' },
            { data: 'lama_loading_hari', name: 'lama_loading_hari' },
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
        var url = "{{ route('contractcpo.export.excel') }}";
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
        var url = "{{ route('contractcpo.export.pdf') }}";
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
        $.get('/contractcpo/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editGguSc').val(data.ggu_sc);
            $('#editGumSc').val(data.gum_sc);
            $('#editPlanLoadingTk').val(data.plan_loading_tk);
            $('#editRealLoadingTk').val(data.real_loading_tk);
            $('#editTglBaLoadingTk').val(data.tgl_ba_loading_tk);
            $('#editTglPricing').val(data.tgl_pricing);
            $('#editRealPrice').val(data.real_price);
            $('#editNilaiPenjualan').val(data.nilai_penjualan);
            $('#editKontrakQtyTon').val(data.kontrak_qty_ton);
            $('#editRealQtyKg').val(data.real_qty_kg);
            $('#editKapalTongkang').val(data.kapal_tongkang);
            $('#editSuhu').val(data.suhu);
            $('#editBuyer').val(data.buyer);
            $('#editStatus').val(data.status);
            $('#editLamaLoadingHari').val(data.lama_loading_hari);
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
            url: '/contractcpo/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditCcpo').modal('hide');
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