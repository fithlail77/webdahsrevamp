@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header">Ubah Data Air Sungai</div>
    <div class="card-body">
        <form action="{{ route('airsungai.update', $AirSungai->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="table-responsive">
                <table class="table table-borderless" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center">
                            <th width="15%">Tanggal</th>
                            <th width="15%">Ketinggian Air Pagi</th>
                            <th width="15%">Ketinggian Air Sore</th>
                            <th width="15%">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="date" name="tanggal" class="form-control" value="{{ $AirSungai->tanggal }}" required></td>
                            <td><input type="number" name="pagi_m" class="form-control" min="0" step="0.1" value="{{ $AirSungai->pagi_m }}" required></td>
                            <td><input type="number" name="sore_m" class="form-control" min="0" step="0.1" value="{{ $AirSungai->sore_m }}" required></td>
                            <td><input type="number" name="rataan" class="form-control" min="0" step="0.1" value="{{ $AirSungai->rataan }}" required></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <a href="{{ route('airsungai.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection