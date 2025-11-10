@extends('layouts.admin')

@push('styles')
    <!-- css jspreadsheet + jsuites -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jspreadsheet-ce@4.9.10/dist/jspreadsheet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsuites@4.9.10/dist/jsuites.css" />
@endpush

@section('content')
<h3>📋 Input Data Kordinat Blok</h3>
<hr>
<div class="card shadow mb-4">
    <div class="card-body">
        <div id="spreadsheet"></div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" id="saveBtn">💾 Simpan</button>
            <a href="{{ route('blokkoordinat.index') }}" class="btn btn-secondary btn-sm btn-flat">⬅️ Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- load jsuites dahulu, lalu jspreadsheet -->
    <script src="https://cdn.jsdelivr.net/npm/jsuites@4.9.10/dist/jsuites.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspreadsheet-ce@4.9.10/dist/index.js"></script>

    <script>
       document.addEventListener('DOMContentLoaded', function () {

        const data = [
            ["", "", "", "", "", "", "", ""]
        ];

        const table = jspreadsheet(document.getElementById('spreadsheet'), {
            data: data,
            columns: [
                { type: 'text', title: 'Estate', width: 150 },
                { type: 'text', title: 'Divisi', width: 150 },
                { type: 'text', title: 'Blok', width: 150 },
                { type: 'text', title: 'x', width: 250 },
                { type: 'text', title: 'y', width: 250 },
                { type: 'text', title: 'L1', width: 150 },
                { type: 'text', title: 'L2', width: 150 },
                { type: 'text', title: 'Poly ID', width: 150 },
            ],
            minSpareRows: 1,
            allowInsertRow: true,
            allowDeleteRow: true,
            rowResize: true,
        });

        document.getElementById('saveBtn').addEventListener('click', function () {
            let users = table.getData();
            const columns = ['estate','divisi','blok','x','y','l1','l2','poly_id'];
            const payload = users
                .filter(row => row.some(cell => cell !== null && String(cell).trim() !== ''))
                .map(row => {
                    let obj = {};
                    columns.forEach((col, i) => obj[col] = row[i] ?? null);
                    return obj;
                });

            fetch("{{ route('blokkoordinat.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ blokkordinat: payload })
            })
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                alert(data.message ?? 'Data berhasil disimpan');
                window.location.href = '{{ route("blokkoordinat.index") }}';
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi error saat menyimpan. Cek console.');
            });
        });

    });
    </script>    
@endpush