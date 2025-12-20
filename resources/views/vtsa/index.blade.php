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
        var url = "{{ route('sptbs.export.excel') }}";
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
        var url = "{{ route('sptbs.export.pdf') }}";
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
        $.get('/sptbs/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editAngkutan').val(data.angkutan);
            $('#editNoTiket').val(data.no_tiket);
            $('#editTanggalTiket').val(data.tanggal_tiket ? data.tanggal_tiket.split(' ')[0] : '');
            $('#editNoSptbs').val(data.no_sptbs);
            $('#editTanggalSptbs').val(data.tanggal_sptbs ? data.tanggal_sptbs.split(' ')[0] : '');
            $('#editTanggalPanen').val(data.tanggal_panen ? data.tanggal_panen.split(' ')[0] : '');
            $('#editNamaSupir').val(data.nama_supir);
            $('#editNoPolisi').val(data.no_polisi);
            $('#editJamMasuk').val(data.jam_masuk);
            $('#editJamKeluar').val(data.jam_keluar);
            $('#editEstate').val(data.estate);
            $('#editDivisi').val(data.divisi);
            $('#editBlok').val(data.blok);
            $('#editTahunTanam').val(data.tahun_tanam);
            $('#editLahan').val(data.lahan);
            $('#editJumlahTandan').val(data.jumlah_tandan);
            $('#editBerondolan').val(data.berondolan);
            $('#editBeratBruto').val(data.berat_bruto);
            $('#editBeratTarra').val(data.berat_tarra);
            $('#editBeratNetto').val(data.berat_netto);
            $('#editJumlahGrading').val(data.jumlah_grading);
            $('#editBeratBersih').val(data.berat_bersih);
            $('#editBjr').val(data.bjr);
            $('#editF00').val(data.f00);
            $('#editF0').val(data.f0);
            $('#editF14').val(data.f14);
            $('#editF5').val(data.f5);
            $('#editF6').val(data.f6);
            $('#editTKosong').val(data.t_kosong);
            $('#editSampah').val(data.sampah);
            $('#editTangkaiPjg').val(data.tangkai_pjg);
            $('#editKastrasi').val(data.kastrasi);
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
            url: '/sptbs/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditSptbs').modal('hide');
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

    // Auto replace comma with dot for BJR input
    $('#bjr').on('input', function() {
        var value = $(this).val();
        if (value.includes(',')) {
            $(this).val(value.replace(/,/g, '.'));
        }
    });

    // Handle form submission for Add SPTBS modal
    $('#modal-AddSPTBS form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("sptbs.simpan") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modal-AddSPTBS').modal('hide');
                table.ajax.reload();
                toastr.success('Data SPTBS berhasil disimpan.');
                // Reset form
                $('#modal-AddSPTBS form')[0].reset();
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