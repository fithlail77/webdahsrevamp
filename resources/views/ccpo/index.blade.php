@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Penjualan CPO</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAirSungai" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadCCPO" align="right">
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
        <table id="ccpoTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>GGU SC</th>
                    <th>GUM SC</th>
                    <th>Tanggal Plan Loading</th>
                    <th>Tanggal Real Loading</th>
                    <th>Tanggal BA Loading</th>
                    <th>Tanggal Pricing</th>
                    <th>Harga</th>
                    <th>Nilai Penjualan</th>
                    <th>Kuantiti Kontrak</th>
                    <th>Kuantiti Real</th>
                    <th>Armada</th>
                    <th>Suhu</th>
                    <th>Pembeli</th>
                    <th>Status</th>
                    <th>Hari Loading</th>
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
<div class="modal fade" id="modal-UploadCCPO" tabindex="-1" role="dialog" aria-labelledby="modal-UploadCCPOLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadCCPOLabel">Unggah Kontrak CPO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('contractcpo.import') }}" method="POST" enctype="multipart/form-data">
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
<!-- Modal Edit Data Contract CPO -->
<div class="modal fade" id="modal-EditCcpo" tabindex="-1" role="dialog" aria-labelledby="modal-EditCcpoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditCcpoLabel">Ubah Data Kontrak CPO</h5>
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
<style>
    .dt-nowrap {
        white-space: nowrap;
    }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#ccpoTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('contractcpo.data') }}",
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
            { data: 'ggu_sc', name: 'ggu_sc'},
            { data: 'gum_sc', name: 'gum_sc'},
            { data: 'tanggal_formatted1', name: 'tanggal_formatted1' },
            { data: 'tanggal_formatted2', name: 'tanggal_formatted2' },
            { data: 'tanggal_formatted3', name: 'tanggal_formatted3' },
            { data: 'tanggal_formatted4', name: 'tanggal_formatted4' },
            { data: 'real_price', name: 'real_price' },
            { data: 'nilai_penjualan', name: 'nilai_penjualan' },
            { data: 'kontrak_qty_ton', name: 'kontrak_qty_ton' },
            { data: 'real_qty_kg', name: 'real_qty_kg' },
            { data: 'kapal_tongkang', name: 'kapal_tongkang' },
            { data: 'suhu', name: 'suhu' },
            { data: 'buyer', name: 'buyer' },
            { data: 'status', name: 'status' },
            { data: 'lama_loading_hari', name: 'lama_loading_hari' },
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
            $('#editJenisPerawatan').val(data.jenis_perawatan);
            $('#editBlok').val(data.blok);
            $('#editTahunTanam').val(data.tahun_tanam);
            $('#editDivisi').val(data.divisi);
            $('#editEstate').val(data.estate);
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
});
</script>
@endpush