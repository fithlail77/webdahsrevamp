@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h4 mb-2 text-gray-800">Data Air Sungai Kapuas</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadAirSungai" align="right">
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
<!-- Area chart example-->
<!--<div class="card mb-2">
    <div class="card-header">Grafik Air Sungai Kapuas</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="AirSungaiChart1" width="100%" height="20"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
</div>-->
<div class="card shadow mb-4">
    <div class="card-body">
        <table id="airsungaiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Tinggi Air Pagi</th>
                    <th>Tinggi Air Sore</th>
                    <th>Rata-rata</th>
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
<div class="modal fade" id="modal-UploadAirSungai" tabindex="-1" role="dialog" aria-labelledby="modal-UploadAirSungaiLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadAirSungaiLabel">Unggah Data Air Sungai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('airsungai.import') }}" method="POST" enctype="multipart/form-data">
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

<!-- Modal Tambah Aresta -->
<div class="modal fade" id="modal-AddAirSungai" tabindex="-1" role="dialog" aria-labelledby="modal-AddAirSungaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddAirSungaiLabel">Tambah Data Air Sungai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('airsungai.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-borderless" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Tanggal</th>
                            <th width="10%">Tinggi Air Pagi</th>
                            <th width="10%">Tinggi Air Sore</th>
                            <th width="10%">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required></td>
                            <td><input type="number" name="pagi_m" class="form-control" min="0" step="0.1"></td>
                            <td><input type="number" name="sore_m" class="form-control" min="0" step="0.1"></td>
                            <td><input type="number" name="rataan" class="form-control" min="0" step="0.1"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right mt-3">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Air Sungai -->
<div class="modal fade" id="modal-EditAirSungai" tabindex="-1" role="dialog" aria-labelledby="modal-EditAirSungaiLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditAirSungaiLabel">Ubah Data Air Sungai Kapuas</h5>
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
                <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="editTinggiPagi">Tinggi Air Pagi</label>
                <input type="number" class="form-control" id="editTinggiPagi" name="pagi_m">
            </div>
            <div class="form-group">
                <label for="editTinggiSore">Tinggi Air Sore</label>
                <input type="number" class="form-control" id="editTinggiSore" name="sore_m" required>
            </div>
            <div class="form-group">
                <label for="editRata">Rata-rata</label>
                <input type="number" step="0.01" class="form-control" id="editRata" name="rataan" required>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#airsungaiTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('airsungai.data') }}",
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
            { data: 'pagi_m', name: 'pagi_m' },
            { data: 'sore_m', name: 'sore_m' },
            { data: 'rataan', name: 'rataan' },
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
        var url = "{{ route('airsungai.export.excel') }}";
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
        var url = "{{ route('airsungai.export.pdf') }}";
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
        $.get('/airsungai/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editTinggiPagi').val(data.pagi_m);
            $('#editTinggiSore').val(data.sore_m);
            $('#editRata').val(data.rataan);
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
            url: '/airsungai/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditAirSungai').modal('hide');
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
    const labels1 = @json($labels1);
    const values1 = @json($values1);
    const batasAtas = Array(values1.length).fill(800);
    const batasBawah = Array(values1.length).fill(400);

    const ctx1 = document.getElementById('AirSungaiChart1').getContext('2d');
    const AirSungaiChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: labels1,
            datasets: [{
                label: 'Tinggi Air Sungai',
                data: values1,
                fill: false,
                borderColor: 'rgba(54, 162, 235, 1)',
                tension: 0.3,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointRadius: 3,
                },
                {
                label: 'Batas Atas',
                data: batasAtas,
                borderColor: 'gold',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                },
                {
                label: 'Batas Bawah',
                data: batasBawah,
                borderColor: 'navy',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 0,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: 200,
                    suggestedMax: 1100
                }
            }
        }
    });
</script>-->
   
@endpush