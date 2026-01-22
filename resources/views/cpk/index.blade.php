@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Kontrak Kernel</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddCPK" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadCPK" align="right">
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
        <table id="cpkTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>LTC</th>
                    <th>No SC</th>
                    <th>Tanggal Pricing</th>
                    <th>Tanggal Kirim</th>
                    <th>Tanggal Selesai Kirim</th>
                    <th>Kuantiti Kontrak (Kg)</th>
                    <th>Pembeli</th>
                    <th>Status</th>
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
<div class="modal fade" id="modal-UploadCPK" tabindex="-1" role="dialog" aria-labelledby="modal-UploadCPKLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadCPKLabel">Unggah Kontrak CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('contractpk.import') }}" method="POST" enctype="multipart/form-data">
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
<!-- Modal Tambah Data Contract Kernel -->
<div class="modal fade" id="modal-AddCPK" tabindex="-1" role="dialog" aria-labelledby="modal-AddCPKLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddCPKLabel">Tambah Data Kontrak Kernel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('contractpk.simpan') }}" method="POST">
            @csrf
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">No LTC</label>
                        <input class="form-control" name="ltc" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nomor SC</label>
                        <input class="form-control" name="nomor_sc" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Harga</label>
                        <input class="form-control"  name="date_pricing" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Harga</label>
                        <input class="form-control" name="price" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Diskon GGU</label>
                        <input class="form-control" name="dicount_ggu" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Harga Real</label>
                        <input class="form-control" name="real_price" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal DP (90%)</label>
                        <input class="form-control"  name="dp_date" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Rencana Awal Kirim</label>
                        <input class="form-control" name="rencana_awal_kirim" type="date"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Rencana Akhir Kirim</label>
                        <input class="form-control" name="rencana_closed_kirim" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Aktual Awal Kirim</label>
                        <input class="form-control" name="actual_awal_kirim" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Aktual Akhir Kirim</label>
                        <input class="form-control" name="actual_closed_kirim" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Kontrak (Kg)</label>
                        <input class="form-control" name="qty_kontrak_kg" type="number" required/>
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
                        <label class="small mb-1">Kuantiti Real Kirim (Kg)</label>
                        <input class="form-control" name="real_qty_kg" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Terima Pembeli</label>
                        <input class="form-control" name="buyer_received_qty_kg" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Nilai Penjualan</label>
                        <input class="form-control" name="rp" type="number" required readonly/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Keterangan</label>
                        <input class="form-control" name="keterangan" type="text"/>
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
<!-- Modal Tambah Data Contract Kernel -->
<div class="modal fade" id="modal-EditCpk" tabindex="-1" role="dialog" aria-labelledby="modal-EditCpkLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditCpkLabel">Ubah Data Kontrak Kernel</h5>
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
                        <label class="small mb-1">No LTC</label>
                        <input class="form-control" name="ltc" id="editLtc" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nomor SC</label>
                        <input class="form-control" name="nomor_sc" id="editNomorSc" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Harga</label>
                        <input class="form-control"  name="date_pricing" id="editDatePricing" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Harga</label>
                        <input class="form-control" name="price" id="editPrice" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Diskon GGU</label>
                        <input class="form-control" name="dicount_ggu" id="editDicountGgu" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Harga Real</label>
                        <input class="form-control" name="real_price" id="editRealPrice" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal DP (90%)</label>
                        <input class="form-control"  name="dp_date" id="editDpDate" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Rencana Awal Kirim</label>
                        <input class="form-control" name="rencana_awal_kirim" id="editRencanaAwalKirim" type="date"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Rencana Akhir Kirim</label>
                        <input class="form-control" name="rencana_closed_kirim" id="editRencanaClosedKirim" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Aktual Awal Kirim</label>
                        <input class="form-control" name="actual_awal_kirim" id="editActualAwalKirim" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Aktual Akhir Kirim</label>
                        <input class="form-control" name="actual_closed_kirim" id="editActualClosedKirim" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Kontrak (Kg)</label>
                        <input class="form-control" name="qty_kontrak_kg" id="editQtyKontrakKg" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Pembeli</label>
                        <input class="form-control" name="buyer" id="editBuyer" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Status</label>
                        <input class="form-control" name="status" id="editStatus" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Real Kirim (Kg)</label>
                        <input class="form-control" name="real_qty_kg" id="editRealQtyKg" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Kuantiti Terima Pembeli</label>
                        <input class="form-control" name="buyer_received_qty_kg" id="editBuyerReceivedQtyKg" type="number" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Nilai Penjualan</label>
                        <input class="form-control" name="rp" id="editRp" type="number" required readonly/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Keterangan</label>
                        <input class="form-control" name="keterangan" id="editKeterangan" type="text"/>
                    </div>
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
    var table = $('#cpkTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('contractpk.data') }}",
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
            { data: 'ltc', name: 'ltc'},
            { data: 'nomor_sc', name: 'nomor_sc'},
            { data: 'tanggal_formatted1', name: 'tanggal_formatted1' },
            { data: 'tanggal_formatted2', name: 'tanggal_formatted2' },
            { data: 'tanggal_formatted3', name: 'tanggal_formatted3' },
            { data: 'qty_kontrak_kg', name: 'qty_kontrak_kg' },
            { data: 'buyer', name: 'buyer' },
            { data: 'status', name: 'status' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });

    // Function to calculate Nilai Penjualan in add modal
    function calculateAddModal() {
        // Hitung Nilai Penjualan = Qty Received Buyer * Price
        var qty = parseFloat($('input[name="buyer_received_qty_kg"]').val()) || 0;
        var price = parseFloat($('input[name="real_price"]').val()) || 0;
        var nilai = qty * price;
        $('input[name="rp"]').val(nilai);
    }

    // Attach event listeners to calculate on input change
    $('input[name="buyer_received_qty_kg"], input[name="real_price"]').on('input', function() {
        calculateAddModal();
    });

    // Function to calculate Nilai Penjualan in edit modal
    function calculateEditModal() {
        // Hitung Nilai Penjualan = Qty Received Buyer * Price
        var qty = parseFloat($('#editBuyerReceivedQtyKg').val()) || 0;
        var price = parseFloat($('#editRealPrice').val()) || 0;
        var nilai = qty * price;
        $('#editRp').val(nilai);
    }

    // Attach event listeners to calculate on input change in edit modal
    $('#editBuyerReceivedQtyKg, #editRealPrice').on('input', function() {
        calculateEditModal();
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
        $.get('/contractpk/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editLtc').val(data.ltc);
            $('#editNomorSc').val(data.nomor_sc);
            $('#editDatePricing').val(data.date_pricing ? data.date_pricing.split(' ')[0] : '');
            $('#editPrice').val(data.price);
            $('#editDicountGgu').val(data.dicount_ggu);
            $('#editRealPrice').val(data.real_price);
            $('#editDpDate').val(data.dp_date);
            $('#editRencanaAwalKirim').val(data.rencana_awal_kirim ? data.rencana_awal_kirim.split(' ')[0] : '');
            $('#editRencanaClosedKirim').val(data.rencana_closed_kirim ? data.rencana_closed_kirim.split(' ')[0] : '');
            $('#editActualAwalKirim').val(data.actual_awal_kirim ? data.actual_awal_kirim.split(' ')[0] : '');
            $('#editActualClosedKirim').val(data.actual_closed_kirim ? data.actual_closed_kirim.split(' ')[0] : '');
            $('#editQtyKontrakKg').val(data.qty_kontrak_kg);
            $('#editBuyer').val(data.buyer);
            $('#editStatus').val(data.status);
            $('#editRealQtyKg').val(data.real_qty_kg);
            $('#editBuyerReceivedQtyKg').val(data.buyer_received_qty_kg);
            $('#editRp').val(data.rp);
            $('#editKeterangan').val(data.keterangan);
            calculateEditModal(); // Calculate rp after loading data
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
            url: '/contractpk/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditCpk').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = [];
                    for (var field in errors) {
                        errorMessages.push(errors[field].join(', '));
                    }
                    toastr.error('Validasi gagal: ' + errorMessages.join('; '));
                } else {
                    toastr.error('Terjadi kesalahan saat memperbarui data.');
                }
            }
        });
    });

    // Handle export buttons
    $('#exportExcel').on('click', function() {
        var minDate = $('#minDate').val();
        var maxDate = $('#maxDate').val();
        var search = table.search();
        var url = "{{ route('contractpk.export.excel') }}";
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
        var url = "{{ route('contractpk.export.pdf') }}";
        var params = [];
        if (minDate) params.push('minDate=' + minDate);
        if (maxDate) params.push('maxDate=' + maxDate);
        if (search) params.push('search=' + encodeURIComponent(search));
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        window.location.href = url;
    });
});
</script>
@endpush