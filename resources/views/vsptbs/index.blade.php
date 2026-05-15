@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Laporan SPTBS</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddSPTBS" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadSptbs">
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
            <table id="sptbsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Angkutan</th>
                        <th>No Tiket</th>
                        <th>Tanggal Tiket</th>
                        <th>No SPTBS</th>
                        <th>Tanggal SPTBS</th>
                        <th>Tanggal Panen</th>
                        <th>Nama Supir</th>
                        <th>No Polisi</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Blok</th>
                        <th>Tahun Tanam</th>
                        <th>Inti/Plasma</th>
                        <th>Jumlah Tandan</th>
                        <th>Berondolan</th>
                        <th>Berat Bruto</th>
                        <th>Berat Tarra</th>
                        <th>Berat Netto</th>
                        <th>Jumlah Grading</th>
                        <th>Berat Bersih</th>
                        <th>BJR</th>
                        <th>F-00</th>
                        <th>F-0</th>
                        <th>F1 s.d F4</th>
                        <th>F-5</th>
                        <th>F-6</th>
                        <th>Tandan Kosong</th>
                        <th>Sampah</th>
                        <th>Tangkai Pjg</th>
                        <th>Kastrasi</th>
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
<!-- Modal Tambah Data SPTBS -->
<div class="modal fade" id="modal-AddSPTBS" tabindex="-1" role="dialog" aria-labelledby="modal-AddSPTBSLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-AddSPTBSLabel">Tambah Data SPTBS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('sptbs.simpan') }}" method="POST">
            @csrf
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Angkutan</label>
                        <input class="form-control" name="angkutan" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">No Tiket</label>
                        <input class="form-control" name="notiket" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Tiket</label>
                        <input class="form-control" name="tgltiket" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">No SPTBS</label>
                        <input class="form-control" name="nosptbs" type="number"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal SPTBS</label>
                        <input class="form-control" name="tglsptbs" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tanggal Panen</label>
                        <input class="form-control" name="tglpanen" type="date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Nama Supir</label>
                        <input class="form-control" name="supir" type="text"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">No Polisi</label></label>
                        <input class="form-control" name="nopol" type="text" />
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Jam Masuk</label>
                        <input class="form-control" name="timein" type="time" step="1"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jam Keluar</label>
                        <input class="form-control" name="timeout" type="time" step="1"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Estate</label>
                        <select class="form-control" name="estate" id="estate" @if($userEstate && $userEstate !== 'all') disabled @endif>
                            <option value="">-- Pilih --</option>
                            @foreach($estate as $item)
                                <option value="{{ $item->estate }}" @if($userEstate && $userEstate !== 'all' && $userEstate == $item->estate) selected @elseif($userEstate == null && $item->estate == old('estate', '')) selected @endif>{{ $item->estate }}</option>
                            @endforeach
                        </select>
                        @if($userEstate && $userEstate !== 'all')
                            <input type="hidden" name="estate" value="{{ $userEstate }}">
                        @endif
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
                        <label class="small mb-1">Inti/Plasma</label>
                        <select class="form-control" name="lahan">
                            <option value="">-- Pilih --</option>
                            <option value="Inti">Inti</option>
                            <option value="Plasma">Plasma</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah Tandan</label></label>
                        <input class="form-control" name="jmltandan" type="number" />
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Berondolan</label>
                        <input class="form-control" name="berondolan" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Bruto</label>
                        <input class="form-control" name="bruto" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Tarra</label>
                        <input class="form-control" name="tarra" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Netto</label>
                        <input class="form-control" name="netto" type="number" readonly/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Jumlah Grading</label>
                        <input class="form-control" name="grading" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Berat Bersih</label>
                        <input class="form-control" name="bersih" type="number" readonly/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">BJR</label>
                        <input class="form-control" name="bjr" id="bjr" type="number" step="0.01" readonly/>
                    </div>
                </div>
                <hr>
                <label class="small mb-1">Grading (Kg)</label>
                <hr>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">F-O0</label>
                        <input class="form-control" name="f00" id="f00" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">F-0</label>
                        <input class="form-control" name="f0" id="f0" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">F1 s.d F4</label>
                        <input class="form-control" name="f14" id="f14" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">F5</label>
                        <input class="form-control" name="f5" id="f5" type="number" step="0.01"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">F6</label>
                        <input class="form-control" name="f6" id="f6" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tandan Kosong</label>
                        <input class="form-control" name="tankos" id="t_kosong" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Sampah</label>
                        <input class="form-control" name="sampah" id="sampah" type="number" step="0.01"/>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Tangkai Pjg</label>
                        <input class="form-control" name="tangkai_pjg" id="tangkai_pjg" type="number" step="0.01"/>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Kastrasi</label>
                        <input class="form-control" name="kastrasi" id="kastrasi" type="number" step="0.01"/>
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
<!-- Modal Edit Data SPTBS -->
<div class="modal fade" id="modal-EditSptbs" tabindex="-1" role="dialog" aria-labelledby="modal-EditSptbsLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-EditSptbsLabel">Edit Data SPTBS</h5>
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
                    <label for="editAngkutan">Angkutan</label>
                    <input type="text" class="form-control" id="editAngkutan" name="angkutan">
                </div>
                <div class="col-md-3">
                    <label for="editNoTiket">No Tiket</label>
                    <input type="text" class="form-control" id="editNoTiket" name="no_tiket">
                </div>
                <div class="col-md-3">
                    <label for="editTanggalTiket">Tanggal Tiket</label>
                    <input type="date" class="form-control" id="editTanggalTiket" name="tanggal_tiket">
                </div>
                <div class="col-md-3">
                    <label for="editNoSptbs">No SPTBS</label>
                    <input type="text" class="form-control" id="editNoSptbs" name="no_sptbs">
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editTanggalSptbs">Tanggal SPTBS</label>
                    <input type="date" class="form-control" id="editTanggalSptbs" name="tanggal_sptbs">
                </div>
                <div class="col-md-3">
                    <label for="editTanggalPanen">Tanggal Panen</label>
                    <input type="date" class="form-control" id="editTanggalPanen" name="tanggal_panen">
                </div>
                <div class="col-md-3">
                    <label for="editNamaSupir">Nama Supir</label>
                    <input type="text" class="form-control" id="editNamaSupir" name="nama_supir">
                </div>
                <div class="col-md-3">
                    <label for="editNoPolisi">No Polisi</label>
                    <input type="text" class="form-control" id="editNoPolisi" name="no_polisi">
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editJamMasuk">Jam Masuk (HH:MM:SS)</label>
                    <input type="time" step="1" class="form-control" id="editJamMasuk" name="jam_masuk">
                </div>
                <div class="col-md-3">
                    <label for="editJamKeluar">Jam Keluar (HH:MM:SS)</label>
                    <input type="time" step="1" class="form-control" id="editJamKeluar" name="jam_keluar">
                </div>
                <div class="col-md-3">
                    <label for="editEstate">Estate</label>
                    <select class="form-control" name="estate" id="editEstate" @if($userEstate && $userEstate !== 'all') disabled @endif>
                        <option value="">-- Pilih --</option>
                        @foreach($estate as $item)
                            <option value="{{ $item->estate }}" @if($userEstate && $userEstate !== 'all' && $userEstate == $item->estate) selected @elseif($userEstate == null && $item->estate == old('estate', '')) selected @endif>{{ $item->estate }}</option>
                        @endforeach
                    </select>
                    @if($userEstate && $userEstate !== 'all')
                        <input type="hidden" name="estate" id="editEstateHidden" value="{{ $userEstate }}">
                    @endif
                </div>
                <div class="col-md-3">
                    <label for="editDivisi">Divisi</label>
                    <select class="form-control" name="divisi" id="editDivisi">
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
                    <label for="editBlok">Blok</label>
                    <select class="form-control" id="editBlok" name="blok">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editTahunTanam">Tahun Tanam</label>
                    <select class="form-control" id="editTahunTanam" name="tahun_tanam">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="editLahan">Inti/Plasma</label>
                    <select class="form-control" name="lahan" id="editLahan">
                            <option value="">-- Pilih --</option>
                            <option value="Inti">Inti</option>
                            <option value="Plasma">Plasma</option>
                        </select>
                </div>
                <div class="col-md-3">
                    <label for="editJumlahTandan">Jumlah Tandan</label>
                    <input type="text" class="form-control" id="editJumlahTandan" name="jumlah_tandan">
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editBerondolan">Berondolan</label>
                    <input type="number" step="0.01" class="form-control" id="editBerondolan" name="berondolan">
                </div>
                <div class="col-md-3">
                    <label for="editBeratBruto">Berat Bruto</label>
                    <input type="number" class="form-control" id="editBeratBruto" name="berat_bruto">
                </div>
                <div class="col-md-3">
                    <label for="editBeratTarra">Berat Tarra</label>
                    <input type="number" class="form-control" id="editBeratTarra" name="berat_tarra">
                </div>
                <div class="col-md-3">
                    <label for="editBeratNetto">Berat Netto</label>
                    <input type="number" class="form-control" id="editBeratNetto" name="berat_netto" readonly>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label for="editJumlahGrading">Jumlah Grading</label>
                    <input type="number" class="form-control" id="editJumlahGrading" name="jumlah_grading">
                </div>
                <div class="col-md-3">
                    <label for="editBeratBersih">Berat Bersih</label>
                    <input type="number" class="form-control" id="editBeratBersih" name="berat_bersih" readonly>
                </div>
                <div class="col-md-3">
                    <label for="editBjr">BJR</label>
                    <input type="number" step="0.01" class="form-control" id="editBjr" name="bjr" readonly>
                </div>
                <div class="col-md-3">
                    <label class="small mb-1">F-O0</label>
                    <input class="form-control" name="f00" id="editF00" type="number" step="0.01"/>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label class="small mb-1">F-0</label>
                    <input class="form-control" name="f0" id="editF0" type="number" step="0.01"/>
                </div>
                <div class="col-md-3">
                    <label class="small mb-1">F1 s.d F4</label>
                    <input class="form-control" name="f14" id="editF14" type="number" step="0.01"/>
                </div>
                <div class="col-md-3">
                    <label class="small mb-1">F5</label>
                    <input class="form-control" name="f5" id="editF5" type="number" step="0.01"/>
                </div>
                <div class="col-md-3">
                    <label class="small mb-1">F6</label>
                    <input class="form-control" name="f6" id="editF6" type="number" step="0.01"/>
                </div>
            </div>
            <div class="row gx-3 mb-3">
                <div class="col-md-3">
                    <label class="small mb-1">Tandan Kosong</label>
                    <input class="form-control" name="t_kosong" id="editTKosong" type="number" step="0.01"/>
                </div>
                <div class="col-md-3">
                    <label class="small mb-1">Sampah</label>
                    <input class="form-control" name="sampah" id="editSampah" type="number" step="0.01"/>
                </div>
                <div class="col-md-3">
                    <label class="small mb-1">Tangkai Pjg</label>
                    <input class="form-control" name="tangkai_pjg" id="editTangkaiPjg" type="number" step="0.01"/>
                </div>
                <div class="col-md-3">
                    <label class="small mb-1">Kastrasi</label>
                    <input class="form-control" name="kastrasi" id="editKastrasi" type="number" step="0.01"/>
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
<div class="modal fade" id="modal-UploadSptbs" tabindex="-1" role="dialog" aria-labelledby="modal-UploadSptbsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-UploadSptbsLabel">Unggah Data SPTBS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('sptbs.import') }}" method="POST" enctype="multipart/form-data">
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
    var table = $('#sptbsTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: false,
        autoWidth: false,
        ajax: {
            url: "{{ route('sptbs.data') }}",
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
            { data: 'angkutan', name: 'angkutan' },
            { data: 'no_tiket', name: 'no_tiket' },
            { data: 'tanggal_formatted1', name: 'tanggal_formatted1' },
            { data: 'no_sptbs', name: 'no_sptbs' },
            { data: 'tanggal_formatted2', name: 'tanggal_formatted2' },
            { data: 'tanggal_formatted3', name: 'tanggal_formatted3' },
            { data: 'nama_supir', name: 'nama_supir' },
            { data: 'no_polisi', name: 'no_polisi' },
            { data: 'jam_masuk', name: 'jam_masuk' },
            { data: 'jam_keluar', name: 'jam_keluar' },
            { data: 'estate', name: 'estate' },
            { data: 'divisi', name: 'divisi' },
            { data: 'blok', name: 'blok' },
            { data: 'tahun_tanam', name: 'tahun_tanam' },
            { data: 'lahan', name: 'lahan' },
            { data: 'jumlah_tandan', name: 'jumlah_tandan' },
            { data: 'berondolan', name: 'berondolan' },
            { data: 'berat_bruto', name: 'berat_bruto' },
            { data: 'berat_tarra', name: 'berat_tarra' },
            { data: 'berat_netto', name: 'berat_netto' },
            { data: 'jumlah_grading', name: 'jumlah_grading' },
            { data: 'berat_bersih', name: 'berat_bersih' },
            { data: 'bjr', name: 'bjr' },
            { data: 'f00', name: 'f00' },
            { data: 'f0', name: 'f0' },
            { data: 'f14', name: 'f14' },
            { data: 'f5', name: 'f5' },
            { data: 'f6', name: 'f6' },
            { data: 't_kosong', name: 't_kosong' },
            { data: 'sampah', name: 'sampah' },
            { data: 'tangkai_pjg', name: 'tangkai_pjg' },
            { data: 'kastrasi', name: 'kastrasi' },
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

            // Load cascading dropdowns for edit
            var estate = data.estate;
            var divisi = data.divisi;
            var blok = data.blok;
            var tahunTanam = data.tahun_tanam;

            // Load divisi options if estate is set
            if (estate) {
                console.log('Loading divisi for estate:', estate);
                $.ajax({
                    url: '{{ route("sptbs.getDivisi") }}',
                    data: { estate: estate },
                    async: false,
                    success: function(divisiData) {
                        console.log('Divisi data received:', divisiData);
                        $('#editDivisi').html('<option value="">-- Pilih --</option>');
                        $.each(divisiData, function(key, value) {
                            var selected = (value.divisi == divisi) ? 'selected' : '';
                            $('#editDivisi').append('<option value="' + value.divisi + '" ' + selected + '>' + value.divisi + '</option>');
                        });
                        console.log('Divisi options loaded, selected divisi:', divisi);

                        // Load blok options if divisi is set
                        if (divisi) {
                            $.ajax({
                                url: '{{ route("sptbs.getBlok") }}',
                                data: { estate: estate, divisi: divisi },
                                async: false,
                                success: function(blokData) {
                                    console.log('Blok data received:', blokData);
                                    $('#editBlok').html('<option value="">-- Pilih --</option>');
                                    $.each(blokData, function(key, value) {
                                        var selected = (value.blok == blok) ? 'selected' : '';
                                        $('#editBlok').append('<option value="' + value.blok + '" ' + selected + '>' + value.blok + '</option>');
                                    });

                                    // Load tahun tanam options if blok is set
                                    if (blok) {
                                        $.ajax({
                                            url: '{{ route("sptbs.getTahunTanam") }}',
                                            data: { estate: estate, divisi: divisi, blok: blok },
                                            async: false,
                                            success: function(tahunData) {
                                                console.log('Tahun tanam data received:', tahunData);
                                                $('#editTahunTanam').html('<option value="">-- Pilih --</option>');
                                                $.each(tahunData, function(key, value) {
                                                    var selected = (value.tahun_tanam == tahunTanam) ? 'selected' : '';
                                                    $('#editTahunTanam').append('<option value="' + value.tahun_tanam + '" ' + selected + '>' + value.tahun_tanam + '</option>');
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

    // Function to calculate all values in add modal
    function calculateAddModal() {
        // Hitung Netto: Bruto - Tarra
        var bruto = parseFloat($('input[name="bruto"]').val()) || 0;
        var tarra = parseFloat($('input[name="tarra"]').val()) || 0;
        var netto = bruto - tarra;
        $('input[name="netto"]').val(netto);

        // Hitung Berat Bersih: Netto - Grading
        var grading = parseFloat($('input[name="grading"]').val()) || 0;
        var bersih = netto - grading;
        $('input[name="bersih"]').val(bersih);

        // Hitung BJR: Berat Bersih / Jumlah Tandan
        var tandan = parseFloat($('input[name="jmltandan"]').val()) || 0;
        var bjr = tandan !== 0 ? (bersih / tandan).toFixed(2) : 0;
        $('#bjr').val(bjr);
    }

    // Function to calculate all values in edit modal
    function calculateEditModal() {
        // Hitung Netto: Bruto - Tarra
        var bruto = parseFloat($('#editBeratBruto').val()) || 0;
        var tarra = parseFloat($('#editBeratTarra').val()) || 0;
        var netto = bruto - tarra;
        $('#editBeratNetto').val(netto);

        // Hitung Berat Bersih: Netto - Grading
        var grading = parseFloat($('#editJumlahGrading').val()) || 0;
        var bersih = netto - grading;
        $('#editBeratBersih').val(bersih);

        // Hitung BJR: Berat Bersih / Jumlah Tandan
        var tandan = parseFloat($('#editJumlahTandan').val()) || 0;
        var bjr = tandan !== 0 ? (bersih / tandan).toFixed(2) : 0;
        $('#editBjr').val(bjr);
    }

    // Event listeners for calculations
    $('input[name="bruto"], input[name="tarra"], input[name="grading"], input[name="jmltandan"]').on('input', calculateAddModal);
    $('#editBeratBruto, #editBeratTarra, #editJumlahGrading, #editJumlahTandan').on('input', calculateEditModal);

    // Cascading dropdowns for Add modal
    $('#estate').on('change', function() {
        var estate = $(this).val();
        $('#divisi').html('<option value="">-- Pilih --</option>');
        $('#blok').html('<option value="">-- Pilih --</option>');
        $('#tahuntanam').html('<option value="">-- Pilih --</option>');
        if (estate) {
            $.get('{{ route("sptbs.getDivisi") }}', { estate: estate }, function(data) {
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
            $.get('{{ route("sptbs.getBlok") }}', { estate: estate, divisi: divisi }, function(data) {
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
            $.get('{{ route("sptbs.getTahunTanam") }}', { estate: estate, divisi: divisi, blok: blok }, function(data) {
                $.each(data, function(key, value) {
                    $('#tahuntanam').append('<option value="' + value.tahun_tanam + '">' + value.tahun_tanam + '</option>');
                });
            });
        }
    });

// Cascading dropdowns for Edit modal
     $('#editEstate').on('change', function() {
         // Jika estate disabled, ambil nilai dari hidden input
         var estate = $(this).val() || $('#editEstateHidden').val();
         $('#editDivisi').html('<option value="">-- Pilih --</option>');
         $('#editBlok').html('<option value="">-- Pilih --</option>');
         $('#editTahunTanam').html('<option value="">-- Pilih --</option>');
         if (estate) {
             $.get('{{ route("sptbs.getDivisi") }}', { estate: estate }, function(data) {
                 $.each(data, function(key, value) {
                     $('#editDivisi').append('<option value="' + value.divisi + '">' + value.divisi + '</option>');
                 });
             });
         }
     });

     $('#editDivisi').on('change', function() {
         var estate = $('#editEstate').val() || $('#editEstateHidden').val();
         var divisi = $(this).val();
         $('#editBlok').html('<option value="">-- Pilih --</option>');
         $('#editTahunTanam').html('<option value="">-- Pilih --</option>');
         if (estate && divisi) {
             $.get('{{ route("sptbs.getBlok") }}', { estate: estate, divisi: divisi }, function(data) {
                 $.each(data, function(key, value) {
                     $('#editBlok').append('<option value="' + value.blok + '">' + value.blok + '</option>');
                 });
             });
         }
     });

     $('#editBlok').on('change', function() {
         var estate = $('#editEstate').val() || $('#editEstateHidden').val();
         var divisi = $('#editDivisi').val();
         var blok = $(this).val();
         $('#editTahunTanam').html('<option value="">-- Pilih --</option>');
         if (estate && divisi && blok) {
             $.get('{{ route("sptbs.getTahunTanam") }}', { estate: estate, divisi: divisi, blok: blok }, function(data) {
                 $.each(data, function(key, value) {
                     $('#editTahunTanam').append('<option value="' + value.tahun_tanam + '">' + value.tahun_tanam + '</option>');
                 });
             });
         }
     });
});
</script>
@endpush
