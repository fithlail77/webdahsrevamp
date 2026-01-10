@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Monitoring Aramco</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAramco">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadAramco">
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
            <table id="aramcoTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Rakit</th>
                        <th>Tanggal Pasang</th>
                        <th>No PO</th>
                        <th>Ukuran</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Blok</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Koordinat</th>
                        <th>Tahun Tanam</th>
                        <th>Lahan</th>
                        <th>Status</th>
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
<!-- Modal Tambah Data Aramco -->
<div class="modal fade" id="modal-AddAramco" tabindex="-1" role="dialog" aria-labelledby="modal-AddAramcoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddAramcoLabel">Tambah Data Pemasangan Aramco</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('aramco.store') }}" method="POST">
            @csrf
            <div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Rakit</label>
                        <input class="form-control" name="tanggal_rakit" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Pasang</label>
                        <input class="form-control" name="tanggal_pasang" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">No PO</label>
                        <input class="form-control" name="no_po" type="text"/>
                    </div>
                     <div class="col-md-3">
                        <label class="small mb-1">Ukuran</label>
                        <input class="form-control" name="ukuran" type="text"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah</label>
                        <input class="form-control" name="jumlah" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan</label>
                        <input class="form-control" name="satuan" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Blok</label>
                        <input class="form-control" name="blok" type="text"/>
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
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Divisi</label>
                        <select class="form-control" name="divisi">
                            <option value="">-- Pilih --</option>
                            @foreach($divisi as $item)
                                <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Koordinat</label>
                        <input class="form-control" name="kordinat" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tahun Tanam</label>
                        <input class="form-control" name="tahun_tanam" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Lahan</label>
                        <select class="form-control" name="lahan">
                            <option value="">-- Pilih --</option>
                            <option value="TM">TM</option>
                            <option value="TBM">TBM</option>
                        </select>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Status</label>
                        <input class="form-control" name="status" type="text"/>
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
<!-- Modal Edit Aramco -->
<div class="modal fade" id="modal-EditAramco" tabindex="-1" role="dialog" aria-labelledby="modal-EditAramcoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditAramcoLabel">Edit Data Pemasangan Aramco</h5>
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
                    <label for="editTanggalRakit">Tanggal Rakit</label>
                    <input type="date" class="form-control" id="editTanggalRakit" name="tanggal_rakit" required>
                </div>
                <div class="col-md-3">
                    <label for="editTanggalPasang">Tanggal Pasang</label>
                    <input type="date" class="form-control" id="editTanggalPasang" name="tanggal_pasang" required>
                </div>
                <div class="col-md-3">
                    <label for="editNoPo">No PO</label>
                    <input type="text" class="form-control" id="editNoPo" name="no_po">
                </div>
                <div class="col-md-3">
                    <label for="editUkuran">Ukuran</label>
                    <input type="text" class="form-control" id="editUkuran" name="ukuran" required>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editJumlah">Jumlah</label>
                    <input type="number" class="form-control" id="editJumlah" name="jumlah" required>
                </div>
                <div class="col-md-3">
                    <label for="editSatuan">Satuan</label>
                    <input type="text" class="form-control" id="editSatuan" name="satuan" required>
                </div>
                <div class="col-md-3">
                    <label for="editBlok">Blok</label>
                    <input type="text" class="form-control" id="editBlok" name="blok" required>
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
            </div>
            <div class="row gx-3 mb-3">
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
                    <label for="editTitikKordinat">Titik Kordinat</label>
                    <input type="text" class="form-control" id="editTitikKordinat" name="kordinat" required>
                </div>
                <div class="col-md-3">
                    <label for="editTahunTanam">Tahun Tanam</label>
                    <input type="number" class="form-control" id="editTahunTanam" name="tahun_tanam" required>
                </div>
                <div class="col-md-3">
                    <label for="editLahan">Lahan</label>
                    <select class="form-control" name="lahan" id="editLahan" required>
                        <option value="">-- Pilih --</option>
                        <option value="TM">TM</option>
                        <option value="TBM">TBM</option>
                    </select>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editStatus">Status</label>
                    <input type="text" class="form-control" id="editStatus" name="status">
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
<div class="modal fade" id="modal-UploadAramco" tabindex="-1" role="dialog" aria-labelledby="modal-UploadAramcoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadAramcoLabel">Unggah Data Pemasangan Aramco</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('aramco.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#aramcoTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('aramco.data') }}",
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
            { data: 'tanggal_formatted1', name: 'tanggal_formatted1' },
            { data: 'tanggal_formatted', name: 'tanggal_formatted' },
            { data: 'no_po', name: 'no_po' },
            { data: 'ukuran', name: 'ukuran' },
            { data: 'jumlah', name: 'jumlah' },
            { data: 'satuan', name: 'satuan' },
            { data: 'blok', name: 'blok' },
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'kordinat', name: 'kordinat' },
            { data: 'tahun_tanam', name: 'tahun_tanam' },
            { data: 'lahan', name: 'lahan' },
            { data: 'status', name: 'status' },
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
        var url = "{{ route('aramco.export.excel') }}";
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
        var url = "{{ route('aramco.export.pdf') }}";
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
        $.get('/aramco/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggalRakit').val(data.tanggal_rakit ? data.tanggal_rakit.split(' ')[0] : '');
            $('#editTanggalPasang').val(data.tanggal_pasang ? data.tanggal_pasang.split(' ')[0] : '');
            $('#editNoPo').val(data.no_po);
            $('#editUkuran').val(data.ukuran);
            $('#editJumlah').val(data.jumlah);
            $('#editSatuan').val(data.satuan);
            $('#editBlok').val(data.blok);
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editTitikKordinat').val(data.kordinat);
            $('#editTahunTanam').val(data.tahun_tanam);
            $('#editLahan').val(data.lahan);
            $('#editStatus').val(data.status);
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
            url: '/aramco/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditAramco').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan saat memperbarui data.');
            }
        });
    });

    // Handle form submission for Add Perawatan
    $('#modal-AddAramco form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("aramco.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modal-AddAramco').modal('hide');
                table.ajax.reload();
                toastr.success('Data Perawatan berhasil disimpan.');
                // Reset form
                $('#modal-AddAramco form')[0].reset();
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
});
</script>
@endpush
