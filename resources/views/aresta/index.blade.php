@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Areal Statement</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAresta" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadAreal" align="right">
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
        <table class="table table-bordered table-striped" id="arestaTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Blok</th>
                        <th>TT</th>
                        <th>Status Tanam</th>
                        <th>Status Lahan</th>
                        <th>Bibit</th>
                        <th>Topografi</th>
                        <th>Jenis Tanah</th>
                        <th>Jumlah Pokok</th>
                        <th>Luasan</th>
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
    <div class="row">
        <div class="col-lg-6">
 
            <div class="card mb-5">
            <div class="card-header">Total Pokok Per Estate</div>
                <div class="card-body">
                    <div class="chart-bar"><canvas id="arestaChart1" width="100%" height="50"></canvas></div>
                </div>
                <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
            </div>
            </div>
        <div class="col-lg-6">

            <div class="card mb-5">
            <div class="card-header">Total Luas Per Estate</div>
                <div class="card-body">
                    <div class="chart-bar"><canvas id="arestaChart2" width="100%" height="30"></canvas></div>
                </div>
                <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
            </div>
            </div>
    </div>
</div> -->
<!-- Modal File Upload -->
<div class="modal fade" id="modal-UploadAreal" tabindex="-1" role="dialog" aria-labelledby="modal-UploadArealLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadArealLabel">Unggah Data Areal Statement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('areal.import') }}" method="POST" enctype="multipart/form-data">
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
<div class="modal fade" id="modal-AddAresta" tabindex="-1" role="dialog" aria-labelledby="modal-AddArestaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-AddArestaLabel">Unggah Data Areal Statement</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('areal.store') }}" method="POST">
            @csrf
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal</label>
                        <input class="form-control" name="bulan" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Estate</label>
                        <select class="form-control" name="estate" required>
                            <option value="">-- Pilih --</option>
                            @foreach($estate as $item)
                                <option value="{{ $item->estate }}">{{ $item->estate }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Divisi</label>
                        <select class="form-control" name="divisi" required>
                            <option value="">-- Pilih --</option>
                            @foreach($divisi as $item)
                                <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Blok</label>
                        <input class="form-control" name="blok" type="text" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tahun Tanam</label>
                        <input class="form-control" name="tahun_tanam" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Status Tanaman</label>
                        <select name="status_tanaman" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="TM">TM</option>
                            <option value="TBM">TBM</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Status Lahan</label>
                        <select name="status_lahan" class="form-control" required>
                            <option value="">--Pilih Divisi--</option>
                            <option value="Inti">Inti</option>
                            <option value="Plasma">Plasma</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jenis Bibit</label>
                        <input class="form-control" name="jenis_bibit" type="text" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Topografi</label>
                        <select name="topografi" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Datar">Datar</option>
                            <option value="Berbukit">Berbukit</option>
                            <option value="Bergelombang">Bergelombang</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jenis Tanah</label>
                        <input class="form-control" name="jenis_tanah" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah Pokok</label>
                        <input class="form-control" name="pokok" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Luasan (Ha)</label>
                        <input class="form-control" name="luas" type="number" step="0.01" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Jenis Input</label>
                        <select name="jenis_input" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Penambahan">Penambahan</option>
                            <option value="Pengurangan">Pengurangan</option>
                        </select>
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

<!-- Modal Edit Areal Statement -->
<div class="modal fade" id="modal-EditAresta" tabindex="-1" role="dialog" aria-labelledby="modal-EditArestaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditArestaLabel">Edit Data Areal Statement</h5>
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
                    <label for="editTanggal">Tanggal</label>
                    <input type="date" class="form-control" id="editTanggal" name="bulan" required>
                </div>
                <div class="col-md-3">
                    <label for="editEstate">Estate</label>
                    <select class="form-control" name="estate" id="editEstate" name="estate" required >
                        <option value="">-- Pilih --</option>
                        @foreach($estate as $item)
                            <option value="{{ $item->estate }}">{{ $item->estate }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editDivisi">Divisi</label>
                    <select class="form-control" name="divisi" id="editDivisi" name="divisi" required >
                        <option value="">-- Pilih --</option>
                        @foreach($divisi as $item)
                            <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editBlok">Blok</label>
                    <input type="text" class="form-control" id="editBlok" name="blok" required>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editTahunTanam">Tahun Tanam</label>
                    <input type="numeric" class="form-control" id="editTahunTanam" name="tahun_tanam" required>
                </div>
                <div class="col-md-3">
                    <label for="editStatusTanaman">Status Tanaman</label>
                    <select name="status_tanaman" class="form-control" id="editStatusTanaman" required>
                        <option value="">-- Pilih --</option>
                        <option value="TM">TM</option>
                        <option value="TBM">TBM</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="ediStatusLahann">Status Lahan</label>
                    <select name="status_lahan" class="form-control" id="editStatusLahan" required>
                        <option value="">-- Pilih --</option>
                        <option value="Inti">Inti</option>
                        <option value="Plasma">Plasma</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editJenisBibit">Jenis Bibit</label>
                    <input type="text" class="form-control" id="editJenisBibit" name="jenis_bibit" required>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editTopografi">Topografi</label>
                    <select name="topografi" class="form-control" id="editTopografi" required>
                        <option value="">-- Pilih --</option>
                        <option value="Datar">Datar</option>
                        <option value="Berbukit">Berbukit</option>
                        <option value="Bergelombang">Bergelombang</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editJenisTanah">Jenis Tanah</label>
                    <input type="text" class="form-control" id="editJenisTanah" name="jenis_tanah" required>
                </div>
                <div class="col-md-3">
                    <label for="editPokok">Pokok</label>
                    <input type="numeric" class="form-control" id="editPokok" name="pokok" required>
                </div>
                <div class="col-md-3">
                    <label for="editLuasan">Luasan (Ha)</label>
                    <input type="numeric" step="0.01" class="form-control" id="editLuasan" name="luas" required>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#arestaTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('areal.data') }}",
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
            { data: 'divisi', name: 'divisi' },
            { data: 'blok', name: 'blok' },
            { data: 'tahun_tanam', name: 'tahun_tanam' },
            { data: 'status_tanaman', name: 'status_tanaman' },
            { data: 'status_lahan', name: 'status_lahan' },
            { data: 'jenis_bibit', name: 'jenis_bibit' },
            { data: 'topografi', name: 'topografi' },
            { data: 'jenis_tanah', name: 'jenis_tanah' },
            { data: 'pokok', name: 'pokok' },
            { data: 'luas', name: 'luas' },
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
        var url = "{{ route('areal.export.excel') }}";
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
        var url = "{{ route('areal.export.pdf') }}";
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
        $.get('/areal/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.bulan ? data.bulan.split(' ')[0] : '');
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editBlok').val(data.blok);
            $('#editTahunTanam').val(data.tahun_tanam);
            $('#editStatusTanaman').val(data.status_tanaman);
            $('#editStatusLahan').val(data.status_lahan);
            $('#editJenisBibit').val(data.jenis_bibit);
            $('#editTopografi').val(data.topografi);
            $('#editJenisTanah').val(data.jenis_tanah);
            $('#editPokok').val(data.pokok);
            $('#editLuasan').val(data.luas);
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
            url: '/areal/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditAresta').modal('hide');
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
        const ctx1 = document.getElementById('arestaChart1').getContext('2d');
        const arestaChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels1),
                datasets: [{
                    label: 'Total Pokok',
                    data: @json($values1),
                    backgroundColor: 'rgba(60,130,142, 1)',
                    borderColor: 'rgba(60,130,142, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value.toLocaleString();
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
                            precision:0
                        },
                        title: {
                            display: true,
                            text: 'Pokok'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
    </script>

    <script>
        const ctx2 = document.getElementById('arestaChart2').getContext('2d');
        const arestaChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($labels2),
                datasets: [{
                    label: 'Total Luas',
                    data: @json($values2),
                    backgroundColor: 'rgba(174, 108, 82, 1)',
                    borderColor: 'rgba(174, 108, 82, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
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
                            precision:0
                        },
                        title: {
                            display: true,
                            text: 'Ha'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },
            plugins: [ChartDataLabels]
        });
    </script> -->
@endpush