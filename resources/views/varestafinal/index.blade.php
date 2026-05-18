@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Aresta Final</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <!--<div>
            <a href="{{ route('blokkoordinat.create') }}">
                <button class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </a> 
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadBlokKoordinat">
                <i class="fa fa-upload"></i> Upload
            </button>
        </div>-->
        <div>
            <button class="btn btn-success btn-sm btn-flat" id="exportExcel">
                <i class="fa fa-file-excel"></i> Export Excel
            </button>
            <!--<button class="btn btn-danger btn-sm btn-flat" id="exportPdf">
                <i class="fa fa-file-pdf"></i> Export PDF
            </button>-->
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
            <table id="arestafinalTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Blok</th>
                        <th>Lahan</th>
                        <th>Tahun Tanam</th>
                        <th>Jenis Bibit</th>
                        <th>Topografi</th>
                        <th>Jenis Tanah</th>
                        <th>Status</th>
                        <th>Jumlah Pokok</th>
                        <th>Luas (Ha)</th>
                        <th>SPH</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        <div id="noDataMessage" class="alert alert-warning mt-3" style="display:none;">
            Tidak ada data yang tersedia.
        </div>
    </div>
</div>
<!-- Modal Edit Aresta Final -->
<div class="modal fade" id="modal-EditArestaFinal" tabindex="-1" role="dialog" aria-labelledby="modal-EditArestaFinalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-EditArestaFinalLabel">Edit Areal Statement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='editForm'>
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editId" name="id">
                    <div class="row gx-3 mb-3">
                        <div class="col-md-3">
                            <label class="small mb-1">Estate</label>
                            <input class="form-control" id="editEstate" name="estate" type="text" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Divisi</label>
                            <input class="form-control" id="editDivisi" name="divisi" type="text" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Blok</label>
                            <input class="form-control" id="editBlok" name="blok" type="text" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Tahun Tanam</label>
                            <input class="form-control" id="editTahunTanam" name="tahun_tanam" type="text" required/>
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-3">
                            <label class="small mb-1">Lahan</label>
                            <input class="form-control" id="editLahan" name="lahan" type="text" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Jenis Bibit</label>
                            <input class="form-control" id="editBibit" name="bibit" type="text" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Topografi</label>
                            <input class="form-control" id="editTopografi" name="topografi" type="text" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Jenis Tanah</label>
                            <input class="form-control" id="editJenisTanah" name="jenis_tanah" type="text" required/>
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-3">
                            <label class="small mb-1">Status</label>
                            <input class="form-control" id="editStatus" name="status" type="text" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Jumlah Pokok</label>
                            <input class="form-control" id="editJmlPokok" name="jml_pokok" type="number" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">Luas</label>
                            <input class="form-control" id="editLuas" name="luas" type="number" step="0.01" required/>
                        </div>
                        <div class="col-md-3">
                            <label class="small mb-1">SPH</label>
                            <input class="form-control" id="editSPH" name="sph" type="number" required/>
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
    var table;
    $(document).ready(function() {
        table = $('#arestafinalTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            responsive: false,
            autoWidth: false,
            ajax: {
                url: "{{ route('arestaV1.data') }}"
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
                { data: 'estate', name: 'estate' },
                { data: 'divisi', name: 'divisi' },
                { data: 'blok', name: 'blok' },
                { data: 'lahan', name: 'lahan' },
                { data: 'tahun_tanam', name: 'tahun_tanam' },
                { data: 'bibit', name: 'bibit' },
                { data: 'topografi', name: 'topografi' },
                { data: 'jenis_tanah', name: 'jenis_tanah' },
                { data: 'status', name: 'status' },
                { data: 'jml_pokok', name: 'jml_pokok' },
                { data: 'luas', name: 'luas' },
                { data: 'sph', name: 'sph' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
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
            $.get('/arestaV1/' + id + '/edit', function(data) {
                console.log('Edit data received:', data);
                $('#editId').val(data.id);
                $('#editEstate').val(data.estate);
                $('#editDivisi').val(data.divisi);
                $('#editBlok').val(data.blok);
                $('#editTahunTanam').val(data.tahun_tanam);
                $('#editLahan').val(data.lahan);
                $('#editBibit').val(data.bibit);
                $('#editTopografi').val(data.topografi);
                $('#editJenisTanah').val(data.jenis_tanah);
                $('#editStatus').val(data.status);
                $('#editJmlPokok').val(data.jml_pokok);
                $('#editLuas').val(data.luas);
                $('#editSPH').val(data.sph);
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
                url: '/arestaV1/' + id,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#modal-EditArestaFinal').modal('hide');
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

        // Handle export buttons
        $('#exportExcel').on('click', function() {
            var search = table.search();
            var url = "{{ route('arestaV1.export.excel') }}";
            var params = [];
            if (search) params.push('search=' + encodeURIComponent(search));
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            window.location.href = url;
        });

        $('#exportPdf').on('click', function() {
            var search = table.search();
            var url = "{{ route('arestaV1.export.pdf') }}";
            var params = [];
            if (search) params.push('search=' + encodeURIComponent(search));
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            window.location.href = url;
        });
    });
</script>    
@endpush