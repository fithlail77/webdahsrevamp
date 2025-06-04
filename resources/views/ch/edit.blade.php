@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header">Ubah Data Curah Hujan</div>
    <div class="card-body">
        <form action="{{ route('curah.update', $ChInput->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="table-responsive">
                <table class="table table-borderless" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center">
                            <th width="10%">PT</th>
                            <th width="10%">Tanggal</th>
                            <th width="15%">Estate</th>
                            <th width="15%">Divisi</th>
                            <th width="10%">Curah Hujan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="pt" class="form-control" required>
                                    <option value="">--Pilih Perusahaan--</option>
                                    <option value="GUM" {{ $ChInput->pt == 'GUM' ? 'selected' : '' }}>GUM</option>
                                    <option value="PAM" {{ $ChInput->pt == 'PAM' ? 'selected' : '' }}>PAM</option>
                                    <option value="TBSM" {{ $ChInput->pt == 'TBSM' ? 'selected' : '' }}>TBSM</option>
                                </select>
                            </td>
                            <td>
                                <input type="date" name="dates" class="form-control" value="{{ $ChInput->dates }}" required>
                            </td>
                            <td>
                                <select name="estate" class="form-control" required>
                                    <option value="">--Pilih Estate--</option>
                                    <option value="Sedadung" {{ $ChInput->estate == 'Sedadung' ? 'selected' : '' }}>Sedadung</option>
                                    <option value="Melamor" {{ $ChInput->estate == 'Melamor' ? 'selected' : '' }}>Melamor</option>
                                    <option value="Tugang" {{ $ChInput->estate == 'Tugang' ? 'selected' : '' }}>Tugang</option>
                                    <option value="Mulau" {{ $ChInput->estate == 'Mulau' ? 'selected' : '' }}>Mulau</option>
                                    <option value="Ngaring" {{ $ChInput->estate == 'Ngaring' ? 'selected' : '' }}>Ngaring</option>
                                    <option value="GMO" {{ $ChInput->estate == 'GMO' ? 'selected' : '' }}>GMO</option>
                                </select>
                            </td>
                            <td>
                                <select name="divisi" class="form-control" required>
                                    <option value="">--Pilih Divisi--</option>
                                    @for ($i = 0; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $ChInput->divisi == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                </select>
                            </td>
                            <td>
                                <input type="text" name="ch" class="form-control" value="{{ $ChInput->ch }}" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <a href="{{ route('curah.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection