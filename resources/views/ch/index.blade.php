@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Curah Hujan</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddCH" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadCH" align="right">
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
        <table id="chTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Perusahaan</th>
                    <th>Tanggal</th>
                    <th>Estate</th>
                    <th>Divisi</th>
                    <th>Curah Hujan</th>
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
<!--<div class="card shadow mb-4">
    <div class="card mb-2">
        <div class="card-header">Rata rata Curah Hujan - Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
            <div class="card-body">
                <div class="chart-area"><canvas id="CurahHujanChart1" width="100%" height="25"></canvas></div>
            </div>
            <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
        </div>
    </div>
</div>-->

<!-- Modal Import Data Curah Hujan -->
<div class="modal fade" id="modal-UploadCH" tabindex="-1" role="dialog" aria-labelledby="modal-UploadCHLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadCHLabel">Unggah Data Curah Hujan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('curah.import') }}" method="POST" enctype="multipart/form-data">
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

<!-- Modal Tambah Curah Hujan -->
<div class="modal fade" id="modal-AddCH" tabindex="-1" role="dialog" aria-labelledby="modal-AddCHLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddCHLabel">Tambah Data Curah Hujan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('curah.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-borderless" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>PT</th>
                            <th>Tanggal</th>
                            <th>Estate</th>
                            <th>Divisi</th>
                            <th>Curah Hujan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                            <tbody id="hujanBody">
                                <tr>
                                    <td><select name="ChInput[0][pt]" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <option value="GUM">GUM</option>
                                        </select>
                                    </td>
                                    <td><input type="date" name="ChInput[0][dates]" class="form-control"></td>
                                    <td><select name="ChInput[0][estate]" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <option value="Sedadung">Sedadung</option>
                                            <option value="Melamor">Melamor</option>
                                            <option value="Tugang">Tugang</option>
                                            <option value="Mulau">Mulau</option>
                                            <option value="Ngaring">Ngaring</option>
                                            <option value="GMO">GMO</option>
                                        </select>
                                    </td>
                                    <td><select name="ChInput[0][divisi]" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="ChInput[0][ch]" class="form-control"></td>
                                    <td><button type="button" class="remove btn btn-danger" onclick="removeRow(this)">-</button></td>
                                </tr>
                            </tbody>
                </table>
                <div class="text-left mt-1">
                    <button type="button" class="btn btn-success" onclick="addRow()">+</button>
                </div>
                <div class="text-right mt-3">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Curah Hujan -->
<div class="modal fade" id="modal-EditCurahHujan" tabindex="-1" role="dialog" aria-labelledby="modal-EditCurahHujanLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditCurahHujanLabel">Ubah Data Curah Hujan</h5>
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
                <label for="editPerusahaan">Perusahaan</label>
                <input type="text" class="form-control" id="editPerusahaan" name="pt" required>
            </div>
            <div class="form-group">
                <label for="editTanggal">Tanggal</label>
                <input type="date" class="form-control" id="editTanggal" name="dates" required>
            </div>
            <div class="form-group">
                <label for="editEstate">Estate</label>
                <input type="text" class="form-control" id="editEstate" name="estate">
            </div>
            <div class="form-group">
                <label for="editDivisi">Divisi</label>
                <input type="text" class="form-control" id="editDivisi" name="divisi" required>
            </div>
            <div class="form-group">
                <label for="editCurahHujan">Curah Hujan</label>
                <input type="number" step="0.01" class="form-control" id="editCurahHujan" name="ch" required>
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

<script>
    let index = 1;

    function addRow() {
        const tbody = document.getElementById('hujanBody');
        const row = document.createElement('tr');

        row.innerHTML = '<tr>' + 
            '<td><select name="ChInput[' + index + '][pt]" class="form-control" required>' +
                    '<option value="">--Pilih--</option>' +
                    '<option value="GUM">GUM</option>' +
                    '<option value="PAM">PAM</option>' +
                    '<option value="TBSM">TBSM</option>' +
                 '</select>' +
            '</td>' +
            '<td><input type="date" name="ChInput[' + index + '][dates]" class="form-control" required></td>' +
            '<td><select name="ChInput[' + index + '][estate]" class="form-control" required>' +
                    '<option value="">--Pilih--</option>' +
                    '<option value="Sedadung">Sedadung</option>' +
                    '<option value="Melamor">Melamor</option>' +
                    '<option value="Tugang">Tugang</option>' +
                    '<option value="Mulau">Mulau</option>' +
                    '<option value="Ngaring">Ngaring</option>' +
                    '<option value="GMO">GMO</option>' +
                '</select>' +
            '</td>' +
            '<td><select name="ChInput[' + index + '][divisi]" class="form-control" required>' +
                    '<option value="">--Pilih--</option>' +
                    '<option value="0">0</option>' +
                    '<option value="1">1</option>' +
                    '<option value="2">2</option>' +
                    '<option value="3">3</option>' +
                    '<option value="4">4</option>' +
                    '<option value="5">5</option>' +
                    '<option value="6">6</option>' +
                '</select>' +
            '</td>' +
            '<td><input type="number" name="ChInput[' + index + '][ch]" class="form-control" required min="0" step="0.1"></td>' +
            '<td><button type="button" class="btn btn-danger" onclick="removeRow(this)">-</button></td>' +
        '</tr>';

        tbody.appendChild(row);
        index++;
    }

    function removeRow(button) {
        if (document.querySelectorAll('#hujanBody tr').length > 1) {
            button.closest('tr').remove();
        } else {
            alert('Setidaknya harus ada satu baris data');
        }
    }
</script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#chTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('curah.data') }}",
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
            { data: 'pt', name: 'pt' },
            { data: 'tanggal_formatted', name: 'tanggal_formatted' },
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'ch', name: 'ch' },
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
        var url = "{{ route('curah.export.excel') }}";
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
        var url = "{{ route('curah.export.pdf') }}";
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
        $.get('/curah/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editPerusahaan').val(data.pt);
            $('#editTanggal').val(data.dates ? data.dates.split(' ')[0] : '');
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editCurahHujan').val(data.ch);
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
            url: '/curah/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditCurahHujan').modal('hide');
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
        const ctx1 = document.getElementById('CurahHujanChart1').getContext('2d');
        const CurahHujanChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'Avg Curah Hujan (mm)',
                    data: @json($chart1),
                    backgroundColor: 'rgba(5, 44, 117, 1)',
                    borderColor: 'rgba(5, 44, 117, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Rata-Rata Curah Hujan Harian PT GUM'
                    },
                    tooltip: {
                        callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Avg: ' + value.toFixed(2) + ' mm';
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        formatter: function(value) {
                            return value.toFixed(2);
                        },
                        color: '#000'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'mm'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
    </script>-->
@endpush