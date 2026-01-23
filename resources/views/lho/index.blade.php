@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">LHO BBM Input</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
          <!--<button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddLhoBBM" align="right">
                <i class="fa fa-plus"></i> Tambah-->
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadLhoBBM" align="right">
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
        <table id="bbmTable" class="table table-bordered">
          <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Unit</th>
                <th>Kelompok Unit</th>
                <th>Quantity</th>
                <th>Liter</th>
                <th>Biaya</th>
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
<div class="modal fade" id="modal-UploadLhoBBM" tabindex="-1" role="dialog" aria-labelledby="modal-UploadLhoBBMLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadLhoBBMLabel">Unggah Data LHO BBM Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('lhobbm.import') }}" method="POST" enctype="multipart/form-data">
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

<style>
    .dt-nowrap {
        white-space: nowrap;
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
    var table = $('#bbmTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('lho.data') }}",
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
            { data: 'i_no', name: 'i_no' },
            { data: 'transportir', name: 'transportir' },
            { data: 'supir', name: 'supir' },
            { data: 'nopol', name: 'nopol' },
            { data: 'material', name: 'material' },
            { data: 'satuan', name: 'satuan' },
            { data: 'blok', name: 'blok' },
            { data: 'tt', name: 'tt' },
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'lahan', name: 'lahan' },
            { data: 'bruto', name: 'bruto' },
            { data: 'tara', name: 'tara' },
            { data: 'netto', name: 'netto' },
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
        var url = "{{ route('tsa.export.excel') }}";
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
        var url = "{{ route('tsa.export.pdf') }}";
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
        $.get('/tsa/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editNoTicket').val(data.no_ticket);
            $('#editTransportir').val(data.transportir);
            $('#editSupir').val(data.supir);
            $('#editNopol').val(data.nopol);
            $('#editMaterial').val(data.material);
            $('#editSatuan').val(data.satuan);
            $('#editBlok').val(data.blok);
            $('#editTahunTanam').val(data.tt);
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editLahan').val(data.lahan);
            $('#editBruto').val(data.bruto);
            $('#editTara').val(data.tara);
            $('#editNetto').val(data.netto);
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
            url: '/tsa/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditTSA').modal('hide');
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
                } else if (xhr.status === 500 && xhr.responseJSON && xhr.responseJSON.error) {
                    toastr.error('Kesalahan server: ' + xhr.responseJSON.error);
                } else {
                    toastr.error('Terjadi kesalahan saat memperbarui data.');
                }
            }
        });
    });

    // Auto Calculate Netto in add Modal
    $('input[name="bruto"], input[name="tara"]').on('input', function() {
        var awal = parseFloat($('input[name="bruto"]').val()) || 0;
        var akhir = parseFloat($('input[name="tara"]').val()) || 0;
        var total = awal - akhir;
        $('input[name="netto"]').val(total);
    });

    // Auto calculate netto Total in edit modal
    $('#editBruto, #editTara').on('input', function() {
        var awal = parseFloat($('#editBruto').val()) || 0;
        var akhir = parseFloat($('#editTara').val()) || 0;
        var total = awal - akhir;
        $('#editNetto').val(total);
    });
});
</script>
@endsection