@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Perawatan Harian Kebun</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddRawat">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadRawatKebun">
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
            <table id="rawatkebunTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Perawatan</th>
                        <th>Blok</th>
                        <th>Tahun Tanam</th>
                        <th>Divisi</th>
                        <th>Estate</th>
                        <th>Lahan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                        <th>Jumlah Tenaga</th>
                        <th>Material 1</th>
                        <th>Jumlah 1</th>
                        <th>Satuan 1</th>
                        <th>Material 2</th>
                        <th>Jumlah 2</th>
                        <th>Satuan 2</th>
                        <th>Material 3</th>
                        <th>Jumlah 3</th>
                        <th>Satuan 3</th>
                        <th>Keterangan</th>
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
<!-- Modal Tambah Data Perawatan Kebun -->
<div class="modal fade" id="modal-AddRawat" tabindex="-1" role="dialog" aria-labelledby="modal-AddRawatLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddRawatLabel">Tambah Data Perawatan Kebun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('rawatkebun.store') }}" method="POST">
            @csrf
            <div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal</label>
                        <input class="form-control" name="tanggal" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Estate</label>
                        <select class="form-control" name="estate" id="estate">
                            <option value="">-- Pilih --</option>
                            @foreach($estate as $item)
                                <option value="{{ $item->estate }}" {{ $userEstate && $userEstate == $item->estate ? 'selected' : '' }}>{{ $item->estate }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Divisi</label>
                        <select class="form-control" name="divisi" id="divisi">
                            <option value="">-- Pilih --</option>
                            @if($userEstate)
                                @foreach($divisi as $item)
                                    <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Blok</label>
                        <select class="form-control" name="blok" id="blok">
                            <option value="">-- Pilih --</option>
                        </select>
                    </div> 
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tahun Tanam</label>
                        <select class="form-control" name="tahun_tanam" id="tt">
                            <option value="">-- Pilih --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jenis Perawatan</label>
                        <select class="form-control" name="jenis_perawatan">
                            <option value="">-- Pilih --</option>
                            @foreach($pupuk as $item)
                                <option value="{{ $item->rawat }}">{{ $item->rawat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">TM/TBM</label>
                        <select class="form-control" name="lahan">
                            <option value="">-- Pilih --</option>
                            <option value="TM">TM</option>
                            <option value="TBM">TBM</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Hasil</label>
                        <input class="form-control" name="hasil" id="hasil" type="number" step="0.01"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan</label>
                        <select class="form-control" name="satuan">
                            <option value="">-- Pilih --</option>
                            <option value="Pkk">Pokok</option>
                            <option value="Ha">Hektar</option>
                            <option value="Mtr">Meter</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah Tenaga</label>
                        <input class="form-control" name="jml_tenaga" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Material 1</label>
                        <input class="form-control" name="material_1" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah 1</label>
                        <input class="form-control" name="jumlah_1" id="jumlah1" type="number" step="0.01"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan 1</label>
                        <select class="form-control" name="satuan_1">
                            <option value="">-- Pilih --</option>
                            <option value="Ltr">Liter</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Material 2</label>
                        <input class="form-control" name="material_2" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah 2</label>
                        <input class="form-control" name="jumlah_2" id="jumlah2" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan 2</label>
                        <select class="form-control" name="satuan_2">
                            <option value="">-- Pilih --</option>
                            <option value="Ltr">Liter</option>
                        </select>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Material 3</label>
                        <input class="form-control" name="material_3" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah 3</label>
                        <input class="form-control" name="jumlah_3" id="jumlah3" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan 3</label>
                        <select class="form-control" name="satuan_3">
                            <option value="">-- Pilih --</option>
                            <option value="Ltr">Liter</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Keterangan</label>
                        <input class="form-control" name="keterangan" type="text"/>
                    </div>
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
<!-- Modal Edit Data Perawatan Kebun -->
<div class="modal fade" id="modal-EditRawatKebun" tabindex="-1" role="dialog" aria-labelledby="modal-EditRawatKebunLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditRawatKebunLabel">Edit Data Perawatan Kebun</h5>
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
                    <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
                </div>
                <div class="col-md-3">
                    <label for="editEstate">Estate</label>
                    <select class="form-control" name="estate" id="editEstate" required>
                        <option value="">-- Pilih --</option>
                        @foreach($estate as $item)
                            <option value="{{ $item->estate }}">{{ $item->estate }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editDivisi">Divisi</label>
                    <select class="form-control" name="divisi" id="editDivisi" required>
                        <option value="">-- Pilih --</option>
                        @foreach($divisi as $item)
                            <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editBlok">Blok</label>
                    <select class="form-control" id="editBlok" name="blok" required>
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editTahunTanam">Tahun Tanam</label>
                    <select class="form-control" id="editTt" name="tahun_tanam" required>
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editJenisPerawatan">Jenis Perawatan</label>
                    <select class="form-control" id="editJenisPerawatan" name="jenis_perawatan">
                            <option value="">-- Pilih --</option>
                            @foreach($pupuk as $item)
                                <option value="{{ $item->rawat }}">{{ $item->rawat }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-3">
                    <label for="editLahan">Lahan</label>
                    <select class="form-control" name="lahan" id="editLahan" required>
                        <option value="">-- Pilih --</option>
                        <option value="TM">TM</option>
                        <option value="TBM">TBM</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editHasil">Hasil</label>
                    <input type="number" step="0.01" class="form-control" id="editHasil" name="hasil" required>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editSatuan">Satuan</label>
                    <select class="form-control" name="satuan" id="editSatuan" required>
                        <option value="">-- Pilih --</option>
                        <option value="Pkk">Pokok</option>
                        <option value="Ha">Hektar</option>
                        <option value="Mtr">Meter</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editJumlahTenaga">Jumlah Tenaga</label>
                    <input type="number" step="0.01" class="form-control" id="editJumlahTenaga" name="jml_tenaga" required>
                </div>
                <div class="col-md-3">
                    <label for="editMaterial1">Material 1</label>
                    <input type="text" class="form-control" id="editMaterial1" name="material_1">
                </div>
                <div class="col-md-3">
                    <label for="editJumlah1">Jumlah 1</label>
                    <input type="number" step="0.01" class="form-control" id="editJumlah1" name="jumlah_1">
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editSatuan1">Satuan 1</label>
                    <select class="form-control" name="satuan_1" id="editSatuan1">
                        <option value="">-- Pilih --</option>
                        <option value="Ltr">Liter</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editMaterial2">Material 2</label>
                    <input type="text" class="form-control" id="editMaterial2" name="material_2">
                </div>
                <div class="col-md-3">
                    <label for="editJumlah2">Jumlah 2</label>
                    <input type="number" step="0.01" class="form-control" id="editJumlah2" name="jumlah_2">
                </div>
                <div class="col-md-3">
                    <label for="editSatuan2">Satuan 2</label>
                    <select class="form-control" name="satuan_2" id="editSatuan2">
                        <option value="">-- Pilih --</option>
                        <option value="Ltr">Liter</option>
                    </select>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editMaterial3">Material 3</label>
                    <input type="text" class="form-control" id="editMaterial3" name="material_3">
                </div>
                <div class="col-md-3">
                    <label for="editJumlah3">Jumlah 3</label>
                    <input type="number" step="0.01" class="form-control" id="editJumlah3" name="jumlah_3">
                </div>
                <div class="col-md-3">
                    <label for="editSatuan3">Satuan 3</label>
                    <select class="form-control" name="satuan_3" id="editSatuan3">
                        <option value="">-- Pilih --</option>
                        <option value="Ltr">Liter</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editKeterangan">Keterangan</label>
                    <input type="text" class="form-control" id="editKeterangan" name="keterangan">
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

<!-- Modal File Upload -->
<div class="modal fade" id="modal-UploadRawatKebun" tabindex="-1" role="dialog" aria-labelledby="modal-UploadRawatKebunLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadRawatKebunLabel">Unggah Data Perawatan Kebun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('rawatkebun.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#rawatkebunTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('rawatkebun.data') }}",
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
            { data: 'jenis_perawatan', name: 'jenis_perawatan' },
            { data: 'blok', name: 'blok' },
            { data: 'tahun_tanam', name: 'tahun_tanam' },
            { data: 'divisi', name: 'divisi' },
            { data: 'estate', name: 'estate' },
            { data: 'lahan', name: 'lahan' },
            { data: 'hasil', name: 'hasil' },
            { data: 'satuan', name: 'satuan' },
            { data: 'jml_tenaga', name: 'jml_tenaga' },
            { data: 'material_1', name: 'material_1' },
            { data: 'jumlah_1', name: 'jumlah_1' },
            { data: 'satuan_1', name: 'satuan_1' },
            { data: 'material_2', name: 'material_2' },
            { data: 'jumlah_2', name: 'jumlah_2' },
            { data: 'satuan_2', name: 'satuan_2' },
            { data: 'material_3', name: 'material_3' },
            { data: 'jumlah_3', name: 'jumlah_3' },
            { data: 'satuan_3', name: 'satuan_3' },
            { data: 'keterangan', name: 'keterangan' },
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
        var url = "{{ route('rawatkebun.export.excel') }}";
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
        var url = "{{ route('rawatkebun.export.pdf') }}";
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
        $.get('/rawatkebun/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editEstate').val(data.estate);
            $('#editJenisPerawatan').val(data.jenis_perawatan);
            $('#editLahan').val(data.lahan);
            $('#editHasil').val(data.hasil);
            $('#editSatuan').val(data.satuan);
            $('#editJumlahTenaga').val(data.jml_tenaga);
            $('#editMaterial1').val(data.material_1);
            $('#editJumlah1').val(data.jumlah_1);
            $('#editSatuan1').val(data.satuan_1);
            $('#editMaterial2').val(data.material_2);
            $('#editJumlah2').val(data.jumlah_2);
            $('#editSatuan2').val(data.satuan_2);
            $('#editMaterial3').val(data.material_3);
            $('#editJumlah3').val(data.jumlah_3);
            $('#editSatuan3').val(data.satuan_3);
            $('#editKeterangan').val(data.keterangan);

            // Load cascading dropdowns for edit
            var estate = data.estate;
            var divisi = data.divisi;
            var blok = data.blok;
            var tt = data.tahun_tanam;

            // Load divisi options if estate is set
            if (estate) {
                $.ajax({
                    url: '{{ route("rawatkebun.getDivisi") }}',
                    data: { estate: estate },
                    async: false,
                    success: function (divisiData) {
                        $('#editDivisi').html('<option value="">-- Pilih --</option>');
                        $.each(divisiData, function (key, value) {
                            var selected = (value.divisi == divisi) ? 'selected' : '';
                            $('#editDivisi').append('<option value="' + value.divisi + '" ' + selected + '>' + value.divisi + '</option>');
                        })
                        // Load blok options if divisi is set
                        if (divisi) {
                            $.ajax({
                                url: '{{ route("rawatkebun.getBlok") }}',
                                data: { estate: estate, divisi: divisi },
                                async: false,
                                success: function (blokData) {
                                    $('#editBlok').html('<option value="">-- Pilih --</option>');
                                    $.each(blokData, function (key, value) {
                                        var selected = (value.blok == blok) ? 'selected' : '';
                                        $('#editBlok').append('<option value="' + value.blok + '" ' + selected + '>' + value.blok + '</option>');
                                    })
                                    // Load tahun tanam options if blok is set
                                    if (blok) {
                                        $.ajax({
                                            url: '{{ route("rawatkebun.getTahunTanam") }}',
                                            data: { estate: estate, divisi: divisi, blok: blok },
                                            async: false,
                                            success: function (tahunData) {
                                                $('#editTt').html('<option value="">-- Pilih --</option>');
                                                $.each(tahunData, function (key, value) {
                                                    var selected = (value.tahun_tanam == tt) ? 'selected' : '';
                                                    $('#editTt').append('<option value="' + value.tahun_tanam + '" ' + selected + '>' + value.tahun_tanam + '</option>');
                                                });
                                            },
                                            error: function (xhr, status, error) {
                                                console.error('Error loading tahun tanam:', status, error);
                                            }
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error loading blok:', status, error);
                                }
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading divisi:', status, error);
                    }
                });
            }
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
            url: '/rawatkebun/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditRawatKebun').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan saat memperbarui data.');
            }
        });
    });

    // Auto replace comma with dot for Hasil Input
    $('#hasil').on('input', function() {
        var value = $(this).val();
        if (value.includes(',')) {
            $(this).val(value.replace(/,/g, '.'));
        }
    });

    // Auto replace comma with dot for Jumlah 1 Input
    $('#jumlah1').on('input', function() {
        var value = $(this).val();
        if (value.includes(',')) {
            $(this).val(value.replace(/,/g, '.'));
        }
    });

    // Auto replace comma with dot for Jumlah 2 Input
    $('#jumlah2').on('input', function() {
        var value = $(this).val();
        if (value.includes(',')) {
            $(this).val(value.replace(/,/g, '.'));
        }
    });

    // Auto replace comma with dot for Jumlah 3 Input
    $('#jumlah3').on('input', function() {
        var value = $(this).val();
        if (value.includes(',')) {
            $(this).val(value.replace(/,/g, '.'));
        }
    });

    // Handle form submission for Add Perawatan
    $('#modal-AddRawat form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("rawatkebun.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modal-AddRawat').modal('hide');
                table.ajax.reload();
                toastr.success('Data Perawatan berhasil disimpan.');
                // Reset form
                $('#modal-AddRawat form')[0].reset();
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
                    toastr.error('Terjadi kesalahan saat menyimpan data.');
                }
            }
        });
    });

    // Cascading dropdowns for Add modal
    $('#estate').on('change', function () {
        var estate = $(this).val();
        $('#divisi').html('<option value="">-- Pilih --</option>');
        $('#blok').html('<option value="">-- Pilih --</option>');
        $('#tt').html('<option value="">-- Pilih --</option>');
        if (estate) {
            $.get('{{ route("pupukkebun.getDivisi") }}', { estate: estate }, function (data) {
                $.each(data, function (key, value) {
                    $('#divisi').append('<option value="' + value.divisi + '">' + value.divisi + '</option>');
                });
            });
        }
    })
    $('#divisi').on('change', function () {
        var estate = $('#estate').val();
        var divisi = $(this).val();
        $('#blok').html('<option value="">-- Pilih --</option>');
        $('#tt').html('<option value="">-- Pilih --</option>');
        if (estate && divisi) {
            $.get('{{ route("pupukkebun.getBlok") }}', { estate: estate, divisi: divisi }, function (data) {
                $.each(data, function (key, value) {
                    $('#blok').append('<option value="' + value.blok + '">' + value.blok + '</option>');
                });
            });
        }
    })
    $('#blok').on('change', function () {
        var estate = $('#estate').val();
        var divisi = $('#divisi').val();
        var blok = $(this).val();
        $('#tt').html('<option value="">-- Pilih --</option>');
        if (estate && divisi && blok) {
            $.get('{{ route("pupukkebun.getTahunTanam") }}', { estate: estate, divisi: divisi, blok: blok }, function (data) {
                $.each(data, function (key, value) {
                    $('#tt').append('<option value="' + value.tahun_tanam + '">' + value.tahun_tanam + '</option>');
                });
            });
        }
    });

    // Cascading dropdowns for Edit modal
    $('#editEstate').on('change', function () {
        var estate = $(this).val();
        $('#editDivisi').html('<option value="">-- Pilih --</option>');
        $('#editBlok').html('<option value="">-- Pilih --</option>');
        $('#editTt').html('<option value="">-- Pilih --</option>');
        if (estate) {
            $.get('{{ route("realisasipanen.getDivisi") }}', { estate: estate }, function (data) {
                $.each(data, function (key, value) {
                    $('#editDivisi').append('<option value="' + value.divisi + '">' + value.divisi + '</option>');
                });
            });
        }
    })
    $('#editDivisi').on('change', function () {
        var estate = $('#editEstate').val();
        var divisi = $(this).val();
        $('#editBlok').html('<option value="">-- Pilih --</option>');
        $('#editTt').html('<option value="">-- Pilih --</option>');
        if (estate && divisi) {
            $.get('{{ route("realisasipanen.getBlok") }}', { estate: estate, divisi: divisi }, function (data) {
                $.each(data, function (key, value) {
                    $('#editBlok').append('<option value="' + value.blok + '">' + value.blok + '</option>');
                });
            });
        }
    })
    $('#editBlok').on('change', function () {
        var estate = $('#editEstate').val();
        var divisi = $('#editDivisi').val();
        var blok = $(this).val();
        $('#editTt').html('<option value="">-- Pilih --</option>');
        if (estate && divisi && blok) {
            $.get('{{ route("realisasipanen.getTahunTanam") }}', { estate: estate, divisi: divisi, blok: blok }, function (data) {
                $.each(data, function (key, value) {
                    $('#editTt').append('<option value="' + value.tahun_tanam + '">' + value.tahun_tanam + '</option>');
                });
            });
        }
    });
});
</script>
@endpush
