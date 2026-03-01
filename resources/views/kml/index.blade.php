@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">KML Tracking Asisten GUM</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadKml" align="right">
                <i class="fa fa-upload"></i> Upload File
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
            <table id="trackTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Asisten</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Track</th>
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
</div>
<!-- Modal Tambah Data Premi -->
<div class="modal fade" id="modal-UploadKml" tabindex="-1" role="dialog" aria-labelledby="modal-UploadKmlLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadKmlLabel">Unggah Data KML</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('kml.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal</label>
                        <input class="form-control" name="tanggal" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Asisten</label>
                        <input class="form-control" name="nama_asisten" type="text"/>
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
                        <input class="form-control" name="divisi" type="text"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-12">
                            <label class="small mb-1">Pilih file KML</label>
                            <input class="form-control" name="file_kml" type="file"/>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
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
        var table = $('#trackTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            responsive: false,
            autoWidth: false,
            ajax: {
                url: "{{ route('kml.data') }}",
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
    });
</script>
@endpush