@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Leaf Sampling Unit</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadDtLsu" align="right">
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
            <div class="col-md-4">
                <label for="filterTahun">Pilih Tahun</label>
                <!-- Ubah input menjadi select dropdown -->
                <select id="filterTahun" class="form-control">
                    <!-- Option default kosong -->
                    <option value="">-- Tahun --</option>
                    
                    <!-- Looping data tahun dari database -->
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button id="searchBtn" class="btn btn-primary">
                    <i class="fa fa-search"></i> Cari
                </button>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <table id="lsuTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun</th>
                  <th>Blok</th>
                  <th>Estate</th>
                  <th>Divisi</th>
                  <th>Tahun Tanam</th>
                  <th>Luasan</th>
                  <th>Jumlah Pokok</th>
                  <th>Nilai LSU</th>
                  <th>Unsur Hara</th>
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
<div class="modal fade" id="modal-UploadDtLsu" tabindex="-1" role="dialog" aria-labelledby="modal-UploadDtLsuLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadDtLsuLabel">Unggah Data LSU</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('lsuinput.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#lsuTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('lsuinput.data') }}",
            data: function (d) {
                // Mengambil value dari input id="filterTahun" dan mengirimkannya ke request Controller
                d.tahun = $('#filterTahun').val(); 
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'tahun', name: 'tahun'},
            {data: 'blok', name: 'blok'},
            {data: 'estate', name: 'estate'},
            {data: 'divisi', name: 'divisi'},
            {data: 'tahun_tanam', name: 'tahun_tanam'},
            {data: 'luas', name: 'luas'},
            {data: 'pokok', name: 'pokok'},
            {data: 'lsu', name: 'lsu'},
            {data: 'unsur_hara', name: 'unsur_hara'},
            {data: 'aksi', name: 'aksi', orderable: false, searchable: false},
        ]
    });

    $('#searchBtn').on('click', function() {
        table.ajax.reload();
    });
});
</script>
@endpush