@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header">Ubah Data Areal Statement</div>
    <div class="card-body">
        <form action="{{ route('areal.update', $Aresta->id) }}" method="POST">
            @csrf
            @method('PUT')
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
                            <td><input type="date" name="bulan" class="form-control" value="{{ $Aresta->bulan }}" required></td>
                            <td><select name="estate" class="form-control" required>
                                    <option value="">--Pilih Estate--</option>
                                    <option value="Sedadung" {{ $Aresta->estate == 'Sedadung' ? 'selected' : '' }}>Sedadung</option>
                                    <option value="Melamor" {{ $Aresta->estate == 'Melamor' ? 'selected' : '' }}>Melamor</option>
                                    <option value="Tugang" {{ $Aresta->estate == 'Tugang' ? 'selected' : '' }}>Tugang</option>
                                    <option value="Mulau" {{ $Aresta->estate == 'Mulau' ? 'selected' : '' }}>Mulau</option>
                                    <option value="Ngaring" {{ $Aresta->estate == 'Ngaring' ? 'selected' : '' }}>Ngaring</option>
                                </select></td>
                            <td><select name="divisi" class="form-control" required>
                                    <option value="">--Pilih Divisi--</option>
                                    @for ($i = 0; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $Aresta->divisi == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                </select></td>
                            <td><input type="text" name="blok" class="form-control" value="{{ $Aresta->blok }}" required></td>
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
                            <td><input type="text" name="tahun_tanam" class="form-control" value="{{ $Aresta->tahun_tanam }}" required></td>
                            <td><select name="status_tanaman" class="form-control" required>
                                    <option value="">--Pilih Estate--</option>
                                    <option value="TM" {{ $Aresta->status_tanaman == 'TM' ? 'selected' : '' }}>TM</option>
                                    <option value="TBM" {{ $Aresta->status_tanaman == 'TBM' ? 'selected' : '' }}>TBM</option>
                                </select></td>
                            <td><select name="status_lahan" class="form-control" required>
                                    <option value="">--Pilih Divisi--</option>
                                    <option value="Inti" {{ $Aresta->status_lahan == 'Inti' ? 'selected' : '' }}>Inti</option>
                                    <option value="Plasma" {{ $Aresta->status_lahan == 'Plasma' ? 'selected' : '' }}>Plasma</option>
                                </select></td>
                            <td><input type="text" name="jenis_bibit" class="form-control" value="{{ $Aresta->jenis_bibit }}" required></td>
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
                                    <option value="Datar" {{ $Aresta->topografi == 'Datar' ? 'selected' : '' }}>Datar</option>
                                    <option value="Berbukit" {{ $Aresta->topografi == 'Berbukit' ? 'selected' : '' }}>Berbukit</option>
                                    <option value="Bergelombang" {{ $Aresta->topografi == 'Bergelombang' ? 'selected' : '' }}>Bergelombang</option>
                                </select></td>
                            <td><input type="text" name="jenis_tanah" class="form-control" value="{{ $Aresta->jenis_tanah }}" required></td>
                            <td><input type="text" name="pokok" class="form-control" value="{{ $Aresta->pokok }}" required></td>
                            <td><input type="text" name="luas" class="form-control" value="{{ $Aresta->luas }}" required></td>
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
                                    <option value="Penambahan" {{ $Aresta->jenis_input == 'Penambahan' ? 'selected' : '' }}>Penambahan</option>
                                    <option value="Pengurangan" {{ $Aresta->jenis_input == 'Pengurangan' ? 'selected' : '' }}>Pengurangan</option>
                                </select></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <a href="{{ route('areal.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection