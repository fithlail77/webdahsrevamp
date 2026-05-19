@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Log User Login</h1>
<hr>
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
        <table id="loginlogTable" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Tanggal Login</th>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var table = $('#loginlogTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            responsive: true,
            ajax: {
                url: "{{ route('loginlogs.data') }}",
                data: function (d) {
                    d.minDate = $('#minDate').val();
                    d.maxDate = $('#maxDate').val();
                }
            },
            drawCallback: function () {
                var api = this.api();
                if (api.data().count() === 0) {
                    $('#noDataMessage').show();
                } else {
                    $('#noDataMessage').hide();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'user_id', name: 'user_id' },
                { data: 'ip_address', name: 'ip_address' },
                { data: 'user_agent', name: 'user_agent' },
                { data: 'logged_in_at', name: 'logged_in_at' },
            ]
        });

        $('#searchBtn').on('click', function () {
            table.ajax.reload();
        });
    });
</script>
@endpush