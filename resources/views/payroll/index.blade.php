@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Payroll Pemupukan dan Perawatan</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadPayroll" align="right">
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
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="payrolTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Estate</th>
                        <th>Nama Tenaga</th>
                        <th>Jenis Pupuk</th>
                        <th>Quantiti</th>
                        <th>Mandoran</th>
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
</div>
<!-- Modal File Upload -->
<div class="modal fade" id="modal-UploadPayroll" tabindex="-1" role="dialog" aria-labelledby="modal-UploadPayrollLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadPayrollLabel">Unggah Data Payroll Pemupukan Perawatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('payroll.import') }}" method="POST" enctype="multipart/form-data">
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

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#payrolTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            responsive: false,
            autoWidth: false,
            ajax: {
                url: "{{ route('payroll.data') }}",
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
                { data: 'nama', name: 'nama' },
                { data: 'jenis_pupuk', name: 'jenis_pupuk' },
                { data: 'hasil', name: 'hasil' },
                { data: 'nama_mandor', name: 'nama_mandor' },
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
            var url = "{{ route('payroll.export.excel') }}";
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
            var url = "{{ route('payroll.export.pdf') }}";
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