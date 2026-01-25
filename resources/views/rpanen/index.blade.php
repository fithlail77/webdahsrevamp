@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Realisasi Panen</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddRealisasiPanen">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadRealisasiPanen">
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
            <table id="rpanenTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Pekerjaan</th>
                        <th>Blok</th>
                        <th>Tahun Tanam</th>
                        <th>Divisi</th>
                        <th>Estate</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                        <th>Jumlah TK</th>
                        <th>Ha Panen</th>
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
<!-- Modal Tambah Data Realisasi Panen -->
<div class="modal fade" id="modal-AddRealisasiPanen" tabindex="-1" role="dialog" aria-labelledby="modal-AddRealisasiPanenLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddRealisasiPanenLabel">Tambah Realisasi Panen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('realisasipanen.store') }}" method="POST">
            @csrf
            <div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal</label>
                        <input class="form-control" name="tanggal" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jenis Pekerjaan</label></label>
                        <select class="form-control" name="jenis_kerja">
                            <option value="">-- Pilih --</option>
                            <option value="Panen">Panen</option>
                            <option value="Kutip Brondolan">Kutip Brondolan</option>
                        </select>
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
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Blok</label>
                        <select class="form-control" name="blok" id="blok">
                            <option value="">-- Pilih --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tahun Tanam</label>
                        <select class="form-control" name="tahuntanam" id="tahuntanam">
                            <option value="">-- Pilih --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Hasil</label>
                        <input class="form-control" name="hasil" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Satuan</label></label>
                        <select class="form-control" name="satuan">
                            <option value="">-- Pilih --</option>
                            <option value="Jjg">Janjang</option>
                            <option value="Kg">Kilogram</option>
                        </select>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah TK</label>
                        <input class="form-control" name="tk" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Ha Panen</label>
                        <input class="form-control" name="ha_panen" id="hapanen" type="number" step="0.01"/>
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
<!-- Modal Edit Realisasi Panen -->
<div class="modal fade" id="modal-EditRealisasiPanen" tabindex="-1" role="dialog" aria-labelledby="modal-EditRealisasiPanenLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditRealisasiPanenLabel">Edit Data Realisasi Panen</h5>
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
                    <label for="editJenisKerja">Jenis Pekerjaan</label>
                    <select class="form-control" name="jenis_kerja" id="editJenisKerja" required>
                            <option value="">-- Pilih --</option>
                            <option value="Panen">Panen</option>
                            <option value="Kutip Brondolan">Kutip Brondolan</option>
                        </select>
                </div>
                <div class="col-md-3">
                    <label for="editBlok">Blok</label>
                    <select class="form-control" id="editBlok" name="blok" required>
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editTt">Tahun Tanam</label>
                    <select class="form-control" id="editTt" name="tt" required>
                        <option value="">-- Pilih --</option>
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
                    <label for="editEstate">Estate</label>
                    <select class="form-control" name="estate" id="editEstate" required>
                        <option value="">-- Pilih --</option>
                        @foreach($estate as $item)
                            <option value="{{ $item->estate }}">{{ $item->estate }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editHasil">Hasil</label>
                    <input type="number" step="0.01" class="form-control" id="editHasil" name="hasil" required>
                </div>
                <div class="col-md-3">
                    <label for="editSatuan">Satuan</label>
                    <select class="form-control" name="satuan" id="editSatuan" required>
                        <option value="">-- Pilih --</option>
                        <option value="Jjg">Janjang</option>
                        <option value="Kg">Kilogram</option>
                    </select>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editTk">Jumlah TK</label>
                    <input type="number" class="form-control" id="editTk" name="tk" step="0.01" required>
                </div>
                <div class="col-md-3">
                    <label for="editHaPanen">Ha Panen</label>
                    <input type="number" step="0.01" class="form-control" id="editHaPanen" name="ha_panen" required>
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
<div class="modal fade" id="modal-UploadRealisasiPanen" tabindex="-1" role="dialog" aria-labelledby="modal-UploadRealisasiPanenLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadRealisasiPanenLabel">Unggah Data Realisasi Panen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('realisasipanen.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#rpanenTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('realisasipanen.data') }}",
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
            { data: 'jenis_kerja', name: 'jenis_kerja' },
            { data: 'blok', name: 'blok' },
            { data: 'tt', name: 'tt' },
            { data: 'divisi', name: 'divisi' },
            { data: 'estate', name: 'estate' },
            { data: 'hasil', name: 'hasil' },
            { data: 'satuan', name: 'satuan' },
            { data: 'tk', name: 'tk'},
            { data: 'ha_panen', name: 'ha_panen'},
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
        var url = "{{ route('realisasipanen.export.excel') }}";
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
        var url = "{{ route('realisasipanen.export.pdf') }}";
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
        $.get('/realisasipanen/' + id + '/edit', function(data) {
            console.log('Edit data received:', data);
            $('#editId').val(data.id);
            $('#editTanggal').val(data.tanggal ? data.tanggal.split(' ')[0] : '');
            $('#editJenisKerja').val(data.jenis_kerja);
            $('#editEstate').val(data.estate);
            $('#editHasil').val(data.hasil);
            $('#editSatuan').val(data.satuan);
            $('#editTk').val(data.tk);
            $('#editHaPanen').val(data.ha_panen);

            // Load cascading dropdowns for edit
            var estate = data.estate;
            var divisi = data.divisi;
            var blok = data.blok;
            var tt = data.tt;

            // Load divisi options if estate is set
            if (estate) {
                $.ajax({
                    url: '{{ route("realisasipanen.getDivisi") }}',
                    data: { estate: estate },
                    async: false,
                    success: function(divisiData) {
                        $('#editDivisi').html('<option value="">-- Pilih --</option>');
                        $.each(divisiData, function(key, value) {
                            var selected = (value.divisi == divisi) ? 'selected' : '';
                            $('#editDivisi').append('<option value="' + value.divisi + '" ' + selected + '>' + value.divisi + '</option>');
                        });

                        // Load blok options if divisi is set
                        if (divisi) {
                            $.ajax({
                                url: '{{ route("realisasipanen.getBlok") }}',
                                data: { estate: estate, divisi: divisi },
                                async: false,
                                success: function(blokData) {
                                    $('#editBlok').html('<option value="">-- Pilih --</option>');
                                    $.each(blokData, function(key, value) {
                                        var selected = (value.blok == blok) ? 'selected' : '';
                                        $('#editBlok').append('<option value="' + value.blok + '" ' + selected + '>' + value.blok + '</option>');
                                    });

                                    // Load tahun tanam options if blok is set
                                    if (blok) {
                                        $.ajax({
                                            url: '{{ route("realisasipanen.getTahunTanam") }}',
                                            data: { estate: estate, divisi: divisi, blok: blok },
                                            async: false,
                                            success: function(tahunData) {
                                                $('#editTt').html('<option value="">-- Pilih --</option>');
                                                $.each(tahunData, function(key, value) {
                                                    var selected = (value.tahun_tanam == tt) ? 'selected' : '';
                                                    $('#editTt').append('<option value="' + value.tahun_tanam + '" ' + selected + '>' + value.tahun_tanam + '</option>');
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading tahun tanam:', status, error);
                                            }
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error loading blok:', status, error);
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
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
            url: '/realisasipanen/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#modal-EditRealisasiPanen').modal('hide');
                table.ajax.reload();
                toastr.success(response.success);
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan saat memperbarui data.');
            }
        });
    });

    // Auto replace comma with dot for Ha Panen input
    $('#hapanen').on('input', function() {
        var value = $(this).val();
        if (value.includes(',')) {
            $(this).val(value.replace(/,/g, '.'));
        }
    });

    // Handle form submission for Add Realisasi Panen modal
    $('#modal-AddRealisasiPanen form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("realisasipanen.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modal-AddRealisasiPanen').modal('hide');
                table.ajax.reload();
                toastr.success('Data Realisasi Panen berhasil disimpan.');
                // Reset form
                $('#modal-AddRealisasiPanen form')[0].reset();
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
    $('#estate').on('change', function() {
        var estate = $(this).val();
        $('#divisi').html('<option value="">-- Pilih --</option>');
        $('#blok').html('<option value="">-- Pilih --</option>');
        $('#tahuntanam').html('<option value="">-- Pilih --</option>');
        if (estate) {
            $.get('{{ route("realisasipanen.getDivisi") }}', { estate: estate }, function(data) {
                $.each(data, function(key, value) {
                    $('#divisi').append('<option value="' + value.divisi + '">' + value.divisi + '</option>');
                });
            });
        }
    });

    $('#divisi').on('change', function() {
        var estate = $('#estate').val();
        var divisi = $(this).val();
        $('#blok').html('<option value="">-- Pilih --</option>');
        $('#tahuntanam').html('<option value="">-- Pilih --</option>');
        if (estate && divisi) {
            $.get('{{ route("realisasipanen.getBlok") }}', { estate: estate, divisi: divisi }, function(data) {
                $.each(data, function(key, value) {
                    $('#blok').append('<option value="' + value.blok + '">' + value.blok + '</option>');
                });
            });
        }
    });

    $('#blok').on('change', function() {
        var estate = $('#estate').val();
        var divisi = $('#divisi').val();
        var blok = $(this).val();
        $('#tahuntanam').html('<option value="">-- Pilih --</option>');
        if (estate && divisi && blok) {
            $.get('{{ route("realisasipanen.getTahunTanam") }}', { estate: estate, divisi: divisi, blok: blok }, function(data) {
                $.each(data, function(key, value) {
                    $('#tahuntanam').append('<option value="' + value.tahun_tanam + '">' + value.tahun_tanam + '</option>');
                });
            });
        }
    });

    // Cascading dropdowns for Edit modal
    $('#editEstate').on('change', function() {
        var estate = $(this).val();
        $('#editDivisi').html('<option value="">-- Pilih --</option>');
        $('#editBlok').html('<option value="">-- Pilih --</option>');
        $('#editTt').html('<option value="">-- Pilih --</option>');
        if (estate) {
            $.get('{{ route("realisasipanen.getDivisi") }}', { estate: estate }, function(data) {
                $.each(data, function(key, value) {
                    $('#editDivisi').append('<option value="' + value.divisi + '">' + value.divisi + '</option>');
                });
            });
        }
    });

    $('#editDivisi').on('change', function() {
        var estate = $('#editEstate').val();
        var divisi = $(this).val();
        $('#editBlok').html('<option value="">-- Pilih --</option>');
        $('#editTt').html('<option value="">-- Pilih --</option>');
        if (estate && divisi) {
            $.get('{{ route("realisasipanen.getBlok") }}', { estate: estate, divisi: divisi }, function(data) {
                $.each(data, function(key, value) {
                    $('#editBlok').append('<option value="' + value.blok + '">' + value.blok + '</option>');
                });
            });
        }
    });

    $('#editBlok').on('change', function() {
        var estate = $('#editEstate').val();
        var divisi = $('#editDivisi').val();
        var blok = $(this).val();
        $('#editTt').html('<option value="">-- Pilih --</option>');
        if (estate && divisi && blok) {
            $.get('{{ route("realisasipanen.getTahunTanam") }}', { estate: estate, divisi: divisi, blok: blok }, function(data) {
                $.each(data, function(key, value) {
                    $('#editTt').append('<option value="' + value.tahun_tanam + '">' + value.tahun_tanam + '</option>');
                });
            });
        }
    });
});
</script>
@endpush