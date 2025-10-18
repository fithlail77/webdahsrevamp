@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">FFB Internal</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right" disabled>
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadFfbInt" align="right">
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
      <div class="card-header">Grafik TBS Internal GUM -  Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="FfbIntChart" width="100%" height="50"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
    </div>
</div>-->
<div class="card shadow mb-4">
    <div class="card-body">
        <table id="ffbintTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                  <th>No</th>
                  <th>No PO</th>
                  <th>Vendor Detail</th>
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
<div class="modal fade" id="modal-UploadFfbInt" tabindex="-1" role="dialog" aria-labelledby="modal-UploadFfbIntLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadFfbIntLabel">Unggah Data TBS Internal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('ffbinternal.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#ffbintTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('ffbinternal.data') }}",
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
        var url = "{{ route('ffbinternal.export.excel') }}";
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
        var url = "{{ route('ffbinternal.export.pdf') }}";
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
        $.get('/ffbinternal/' + id + '/edit', function(data) {
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
            url: '/ffbinternal/' + id,
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
        const ctx1 = document.getElementById('FfbIntChart').getContext('2d');
        const FfbIntChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Ton Bruto',
                    data:,
                     backgroundColor: 'rgba(154, 200, 243, 1)',
                    borderColor: 'rgba(154, 200, 243, 1)',
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
<!--<script>
const ctx1 = document.getElementById('FfbIntChart').getContext('2d');
const grading = @json($grading);

const FfbIntChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'Ton Bruto',
                data: @json($bruto),
                backgroundColor: @json(array_map(fn($val) => $val >= $target ? '#B0E6B2' : '#F38383', $bruto)),
                borderColor: 'rgba(0,0,0,0.2)',
                borderWidth: 1,
                barThickness: 25, // Menambah lebar batang
                datalabels: {
                    align: 'start',
                    anchor: 'end',
                    offset: 2,
                    padding: {
                        top: 2
                    },
                    formatter: (value, context) => {
                        const idx = context.dataIndex;
                        const percent = grading[idx] ?? 0;
                        return value > 0 ? `${value.toLocaleString()}\n(${percent}%)` : '';
                    },
                    color: '#880E4F',
                    font: { weight: 'bold', size: 9 }
                }
            },
            {
                label: 'Ton Netto (Grading %)',
                data: @json($grading),
                type: 'bar',
                backgroundColor: 'rgba(0,0,0,0)',
                barThickness: 20,
                datalabels: {
                    display: false // disembunyikan karena sudah ditampilkan di batang Ton Bruto
                }
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            datalabels: {
                clip: true
            },
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Ton Bruto Bulan Ini'
            },
            annotation: {
                annotations: {
                    line1: {
                        type: 'line',
                        yMin: {{ $target }},
                        yMax: {{ $target }},
                        borderColor: 'rgba(0, 180, 216, 0.8)',
                        borderWidth: 2,
                        borderDash: [6, 6],
                        label: {
                            content: 'Target/Hari: {{ $target }}',
                            enabled: true,
                            position: 'end',
                            color: '#008CBA',
                            font: { weight: 'bold' }
                        }
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => value.toLocaleString(undefined, {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                        })
                    },
                title: {
                    display: true,
                    text: 'Ton Bruto'
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
</script>-->
@endpush