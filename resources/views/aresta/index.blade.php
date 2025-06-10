@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Areal Statement</h1>
<hr>
<div class="card shadow mb-4">
    <div class="card-header py-3">
            <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-AddAresta" align="right">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-secondary btn-sm btn-flat" data-toggle="modal" data-target="#modal-UploadAreal" align="right">
                <i class="fa fa-upload"></i> Upload
            </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-aresta1" width="100%" cellsapcing="0">
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
                    <?php $no = 1; ?>
                    @foreach ($aresta as $row )
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->bulan)->format('d-m-Y') }}</td>
                        <td>{{ $row->estate }}</td>
                        <td>{{ $row->divisi }}</td>
                        <td>{{ $row->blok }}</td>
                        <td>{{ $row->tahun_tanam }}</td>
                        <td>{{ $row->status_tanaman }}</td>
                        <td>{{ $row->status_lahan }}</td>
                        <td>{{ $row->jenis_bibit }}</td>
                        <td>{{ $row->topografi }}</td>
                        <td>{{ $row->jenis_tanah }}</td>
                        <td>{{ $row->pokok }}</td>
                        <td>{{ $row->luas }}</td>
                        <td>
                            <a href="{{route('areal.edit' ,[$row->id])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" title="Ubah Data">
                                <i class="fas fa-edit fa-sm text-white-50"></i>
                            </a>
                            <a href="/areal/hapus/{{ $row->id }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" title="Hapus Data">
                                <i class="fas fa-trash-alt fa-sm text-white-50"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $no++; ?> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
    <div class="row">
        <div class="col-lg-6">
        <!-- Bar chart example-->
            <div class="card mb-5">
            <div class="card-header">Total Pokok Per Estate</div>
                <div class="card-body">
                    <div class="chart-bar"><canvas id="arestaChart1" width="100%" height="50"></canvas></div>
                </div>
                <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
            </div>
            </div>
        <div class="col-lg-6">
        <!-- Bar chart example-->
            <div class="card mb-5">
            <div class="card-header">Total Luas Per Estate</div>
                <div class="card-body">
                    <div class="chart-bar"><canvas id="arestaChart2" width="100%" height="30"></canvas></div>
                </div>
                <div class="card-footer small text-muted">Updated {{ now()->format('d-m-Y H:i:s') }}</div>
            </div>
            </div>
    </div>

<hr>
<div class="card shadow mb-4">
    <div class="card-header">Data SPH</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-aresta2" width="100%" cellsapcing="0">
                <thead>
                    <tr>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Blok</th>
                        <th>Status Lahan</th>
                        <th>Status Tanaman</th>
                        <th>Tahun Tanam</th>
                        <th>Topografi</th>
                        <th>Jenis Tanah</th>
                        <th>Luas</th>
                        <th>Pokok</th>
                        <th>SPH</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aresta1 as $row1 )
                    <tr>
                        <td>{{ $row1->estate }}</td>
                        <td>{{ $row1->divisi }}</td>
                        <td>{{ $row1->blok }}</td>
                        <td>{{ $row1->status_lahan }}</td>
                        <td>{{ $row1->status_tanaman }}</td>
                        <td>{{ $row1->tahun_tanam }}</td>
                        <td>{{ $row1->topografi }}</td>
                        <td>{{ $row1->jenis_tanah }}</td>
                        <td>{{ $row1->luasan }}</td>
                        <td>{{ $row1->jlh_pokok }}</td>
                        <td>{{ $row1->sph }}</td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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
            <div class="table-responsive">
                <table class="table table-borderless" width="100%" cellspacing="0">
                    <thead>
                        <tr align="left">
                            <th width="10%">Tanggal</th>
                            <th width="10%">Estate</th>
                            <th width="10%">Divisi</th>
                            <th width="10%">Blok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="date" name="bulan" class="form-control" value="{{ date('Y-m-d') }}" required></td>
                            <td><select name="estate" class="form-control" required>
                                    <option value="">--Pilih Estate--</option>
                                    <option value="Sedadung">Sedadung</option>
                                    <option value="Melamor">Melamor</option>
                                    <option value="Tugang">Tugang</option>
                                    <option value="Mulau">Mulau</option>
                                    <option value="Ngaring">Ngaring</option>
                                </select></td>
                            <td><select name="divisi" class="form-control" required>
                                    <option value="">--Pilih Divisi--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select></td>
                            <td><input type="text" name="blok" class="form-control" required></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr align="left">
                            <th width="10%">Tahun Tanam</th>
                            <th width="10%">Status Tanaman</th>
                            <th width="10%">Status Lahan</th>
                            <th width="10%">Jenis Bibit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="tahun_tanam" class="form-control" required></td>
                            <td><select name="status_tanaman" class="form-control" required>
                                    <option value="">--Pilih Estate--</option>
                                    <option value="TM">TM</option>
                                    <option value="TBM">TBM</option>
                                </select></td>
                            <td><select name="status_lahan" class="form-control" required>
                                    <option value="">--Pilih Divisi--</option>
                                    <option value="Inti">Inti</option>
                                    <option value="Plasma">Plasma</option>
                                </select></td>
                            <td><input type="text" name="jenis_bibit" class="form-control" required></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr align="left">
                            <th width="10%">Topografi</th>
                            <th width="10%">Jenis Tanah</th>
                            <th width="10%">Pokok</th>
                            <th width="10%">Luas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><select name="topografi" class="form-control" required>
                                    <option value="">--Pilih Estate--</option>
                                    <option value="Datar">Datar</option>
                                    <option value="Berbukit">Berbukit</option>
                                    <option value="Bergelombang">Bergelombang</option>
                                </select></td>
                            <td><input type="text" name="jenis_tanah" class="form-control" required></td>
                            <td><input type="text" name="pokok" class="form-control" required></td>
                            <td><input type="text" name="luas" class="form-control" required></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr align="left">
                            <th width="10%">Jenis Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><select name="jenis_input" class="form-control" required>
                                    <option value="">--Pilih Estate--</option>
                                    <option value="Penambahan">Penambahan</option>
                                    <option value="Pengurangan">Pengurangan</option>
                                </select></td>
                        </tr>
                    </tbody>
                </table>
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
@endsection

@push('scripts')
    <script>
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
    </script>
@endpush