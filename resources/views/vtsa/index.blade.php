@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Data Monitoring Tankos Solid Abu Boiler</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddTSA" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadTSA">
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
        <table id='tsaTable' class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Tiket</th>
                    <th>Transportir</th>
                    <th>Sopir</th>
                    <th>No Polisi</th>
                    <th>Material</th>
                    <th>Satuan</th>
                    <th>Blok</th>
                    <th>Tahun Tanam</th>
                    <th>Estate</th>
                    <th>Divisi</th>
                    <th>Lahan</th>
                    <th>Bruto</th>
                    <th>Tarra</th>
                    <th>Netto</th>
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
<!-- Modal Input Data TSA -->
<div class="modal fade" id="modal-AddTSA" tabindex="-1" role="dialog" aria-labelledby="modal-AddTSALabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddTSALabel">Tambah Data Tankos Solid Abu Boiler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('tsa.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal</label>
                        <input class="form-control" name="tanggal" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">No Tiket</label>
                        <input class="form-control" name="no_ticket" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Transportir</label>
                        <input class="form-control" name="transportir" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nama Supir</label>
                        <input class="form-control" name="supir" type="text"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">No Polisi</label>
                        <input class="form-control" name="nopol" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Material</label>
                        <select class="form-control" name="material">
                            <option value="">-- Pilih --</option>
                            <option value="tankos">Tankos</option></option>
                            <option value="solid">Solid</option>
                            <option value="abu boiler">Abu Boiler</option>
                        </select> 
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan</label>
                        <input class="form-control" name="satuan" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Blok</label>
                        <input class="form-control" name="blok" type="text" />
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tahun Tanam</label>
                        <input class="form-control" name="tt" type="number"/>
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
                        <select class="form-control" name="divisi">
                            <option value="">-- Pilih --</option>
                            @foreach($divisi as $item)
                                <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Inti/Plasma</label>
                        <select class="form-control" name="lahan">
                            <option value="">-- Pilih --</option>
                            <option value="Inti">Inti</option></option>
                            <option value="Plasma">Plasma</option>
                        </select>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Bruto</label>
                        <input class="form-control" name="bruto" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tarra</label>
                        <input class="form-control" name="tara" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Netto</label></label>
                        <input class="form-control" name="netto" type="number" readonly/>
                    </div>
                </div>
            </div>
            <div class="text-right mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Data TSA -->
<div class="modal fade" id="modal-EditTSA" tabindex="-1" role="dialog" aria-labelledby="modal-EditTSALabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditTSALabel">Ubah Data Tankos Solid Abu Boiler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editId" name="id">
            <div class="table-responsive">
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal</label>
                        <input class="form-control" id="editTanggal" name="tanggal" type="date" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">No Tiket</label>
                        <input class="form-control" id="editNoTicket" name="no_ticket" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Transportir</label>
                        <input class="form-control" id="editTransportir" name="transportir" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nama Supir</label>
                        <input class="form-control" id="editSupir" name="supir" type="text" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">No Polisi</label>
                        <input class="form-control" id="editNopol" name="nopol" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Material</label>
                        <select class="form-control" id="editMaterial" name="material" required>
                            <option value="">-- Pilih --</option>
                            <option value="tankos">Tankos</option></option>
                            <option value="solid">Solid</option>
                            <option value="abu boiler">Abu Boiler</option>
                        </select> 
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan</label>
                        <input class="form-control" id="editSatuan" name="satuan" type="text" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Blok</label>
                        <input class="form-control" id="editBlok" name="blok" type="text" required/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tahun Tanam</label>
                        <input class="form-control" id="editTahunTanam" name="tt" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Estate</label>
                        <select class="form-control" id="editEstate" name="estate" required>
                            <option value="">-- Pilih --</option>
                            @foreach($estate as $item)
                                <option value="{{ $item->estate }}">{{ $item->estate }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Divisi</label>
                        <select class="form-control" id="editDivisi" name="divisi" required>
                            <option value="">-- Pilih --</option>
                            @foreach($divisi as $item)
                                <option value="{{ $item->divisi }}">{{ $item->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Inti/Plasma</label>
                        <select class="form-control" id="editLahan" name="lahan" required>
                            <option value="">-- Pilih --</option>
                            <option value="Inti">Inti</option></option>
                            <option value="Plasma">Plasma</option>
                        </select>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Bruto</label>
                        <input class="form-control" id="editBruto" name="bruto" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tarra</label>
                        <input class="form-control" id="editTara" name="tara" type="number" required/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Netto</label></label>
                        <input class="form-control" id="editNetto" name="netto" type="number" readonly required/>
                    </div>
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
<div class="modal fade" id="modal-UploadTSA" tabindex="-1" role="dialog" aria-labelledby="modal-UploadTSALabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadTSALabel">Unggah Data Monitoring Tankos Solid Abu Boiler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('tsa.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#tsaTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('tsa.data') }}",
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
            { data: 'no_ticket', name: 'no_ticket' },
            { data: 'transportir', name: 'transportir' },
            { data: 'supir', name: 'supir' },
            { data: 'nopol', name: 'nopol' },
            { data: 'material', name: 'material' },
            { data: 'satuan', name: 'satuan' },
            { data: 'blok', name: 'blok' },
            { data: 'tt', name: 'tt' },
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'lahan', name: 'lahan' },
            { data: 'bruto', name: 'bruto' },
            { data: 'tara', name: 'tara' },
            { data: 'netto', name: 'netto' },
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
        var url = "{{ route('tsa.export.excel') }}";
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
        var url = "{{ route('tsa.export.pdf') }}";
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
        $.get('/tsa/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editNoTicket').val(data.no_ticket);
            $('#editTransportir').val(data.transportir);
            $('#editSupir').val(data.supir);
            $('#editNopol').val(data.nopol);
            $('#editMaterial').val(data.material);
            $('#editSatuan').val(data.satuan);
            $('#editBlok').val(data.blok);
            $('#editTahunTanam').val(data.tt);
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editLahan').val(data.lahan);
            $('#editBruto').val(data.bruto);
            $('#editTara').val(data.tara);
            $('#editNetto').val(data.netto);
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
            url: '/tsa/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditTSA').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = [];
                    for (var field in errors) {
                        errorMessages.push(errors[field].join(', '));
                    }
                    toastr.error('Validasi gagal: ' + errorMessages.join('; '));
                } else if (xhr.status === 500 && xhr.responseJSON && xhr.responseJSON.error) {
                    toastr.error('Kesalahan server: ' + xhr.responseJSON.error);
                } else {
                    toastr.error('Terjadi kesalahan saat memperbarui data.');
                }
            }
        });
    });

    // Auto Calculate Netto in add Modal
    $('input[name="bruto"], input[name="tara"]').on('input', function() {
        var awal = parseFloat($('input[name="bruto"]').val()) || 0;
        var akhir = parseFloat($('input[name="tara"]').val()) || 0;
        var total = awal - akhir;
        $('input[name="netto"]').val(total);
    });

    // Auto calculate netto Total in edit modal
    $('#editBruto, #editTara').on('input', function() {
        var awal = parseFloat($('#editBruto').val()) || 0;
        var akhir = parseFloat($('#editTara').val()) || 0;
        var total = awal - akhir;
        $('#editNetto').val(total);
    });
});
</script>
@endpush