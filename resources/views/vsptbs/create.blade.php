@extends('layouts.admin')

@push('styles')
    <!-- css jspreadsheet + jsuites -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jspreadsheet-ce@4.9.10/dist/jspreadsheet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsuites@4.9.10/dist/jsuites.css" />
@endpush

@section('content')
<h3>📋 Input Data SPTBS</h3>
<hr>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div id="spreadsheet" style="overflow-x: auto;"></div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary btn-sm btn-flat" id="saveBtn">💾 Simpan</button>
            <a href="{{ route('sptbs.index') }}" class="btn btn-secondary btn-sm btn-flat">⬅️ Kembali</a>
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
            ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""]
        ];

        const table = jspreadsheet(document.getElementById('spreadsheet'), {
            data: data,
            columns: [
                { type: 'text', title: 'Angkutan', width: 150 },
                { type: 'text', title: 'No Tiket', width: 150 },
                { type: 'calendar', title: 'Tanggal Tiket', width: 150, options: { format: 'YYYY-MM-DD' } },
                { type: 'text', title: 'No SPTBS', width: 250 },
                { type: 'calendar', title: 'Tanggal SPTBS', width: 150, options: { format: 'YYYY-MM-DD' } },
                { type: 'calendar', title: 'Tanggal Panen', width: 150, options: { format: 'YYYY-MM-DD' } },
                { type: 'text', title: 'Nama Supir', width: 150 },
                { type: 'text', title: 'No Plat', width: 150 },
                { type: 'time', title: 'Jam Masuk', width: 150 },
                { type: 'time', title: 'Jam Keluar', width: 150 },
                { type: 'text', title: 'Estate', width: 150 },
                { type: 'text', title: 'Divisi', width: 150 },
                { type: 'text', title: 'Blok', width: 150 },
                { type: 'text', title: 'Tahun Tanam', width: 150 },
                { type: 'text', title: 'Lahan', width: 150 },
                { type: 'text', title: 'Jumlah Tandan', width: 150 },
                { type: 'text', title: 'Berondolan', width: 150 },
                { type: 'text', title: 'Bruto', width: 150 },
                { type: 'text', title: 'Tarra', width: 150 },
                { type: 'text', title: 'Netto', width: 150 },
                { type: 'text', title: 'Jumlah Grading', width: 150 },
                { type: 'text', title: 'Berat Bersih', width: 150 },
                { type: 'text', title: 'BJR', width: 150 },
            ],
            minSpareRows: 15,
            allowInsertRow: true,
            allowDeleteRow: true,
            rowResize: true,
        });

        // Normalisasi input waktu ke format HH:mm:ss
        function normalizeTimeToHHMMSS(input) {
            if (input === null || input === undefined) return null;
            let s = String(input).trim();
            if (s === '') return null;

            // Jika sudah format HH:mm:ss atau H:m:s atau HH:mm atau H:m
            let m = s.match(/^(\d{1,2}):(\d{1,2})(?::(\d{1,2}))?$/);
            if (m) {
                let hh = parseInt(m[1], 10);
                let mm = parseInt(m[2], 10);
                let ss = m[3] ? parseInt(m[3], 10) : 0;
                if (isNaN(hh) || isNaN(mm) || isNaN(ss)) return null;
                if (hh < 0 || hh > 23 || mm < 0 || mm > 59 || ss < 0 || ss > 59) return null;
                return String(hh).padStart(2,'0') + ':' + String(mm).padStart(2,'0') + ':' + String(ss).padStart(2,'0');
            }

            // Jika hanya angka tanpa titik/colon:
            //  HHMMSS (6 digits), HMMSS (5), HHMM (4), HMM (3), HH (2), H (1)
            m = s.match(/^(\d{1,6})$/);
            if (m) {
                let digits = m[1];
                if (digits.length === 6) {
                    let hh = parseInt(digits.slice(0,2),10);
                    let mm = parseInt(digits.slice(2,4),10);
                    let ss = parseInt(digits.slice(4,6),10);
                    if (hh < 0 || hh > 23 || mm < 0 || mm > 59 || ss < 0 || ss > 59) return null;
                    return String(hh).padStart(2,'0') + ':' + String(mm).padStart(2,'0') + ':' + String(ss).padStart(2,'0');
                } else if (digits.length === 5) {
                    // HMMSS -> H:MM:SS
                    let hh = parseInt(digits.slice(0,1),10);
                    let mm = parseInt(digits.slice(1,3),10);
                    let ss = parseInt(digits.slice(3,5),10);
                    if (hh < 0 || hh > 23 || mm < 0 || mm > 59 || ss < 0 || ss > 59) return null;
                    return String(hh).padStart(2,'0') + ':' + String(mm).padStart(2,'0') + ':' + String(ss).padStart(2,'0');
                } else if (digits.length === 4) {
                    // HHMM -> HH:MM:00
                    let hh = parseInt(digits.slice(0,2),10);
                    let mm = parseInt(digits.slice(2,4),10);
                    if (hh < 0 || hh > 23 || mm < 0 || mm > 59) return null;
                    return String(hh).padStart(2,'0') + ':' + String(mm).padStart(2,'0') + ':00';
                } else if (digits.length === 3) {
                    // HMM -> H:MM:00
                    let hh = parseInt(digits.slice(0,1),10);
                    let mm = parseInt(digits.slice(1,3),10);
                    if (hh < 0 || hh > 23 || mm < 0 || mm > 59) return null;
                    return String(hh).padStart(2,'0') + ':' + String(mm).padStart(2,'0') + ':00';
                } else if (digits.length === 2) {
                    // HH -> HH:00:00
                    let hh = parseInt(digits,10);
                    if (hh < 0 || hh > 23) return null;
                    return String(hh).padStart(2,'0') + ':00:00';
                } else if (digits.length === 1) {
                    // H -> H:00:00
                    let hh = parseInt(digits,10);
                    if (hh < 0 || hh > 23) return null;
                    return String(hh).padStart(2,'0') + ':00:00';
                }
            }

            // Jika input seperti "9.30.5" atau "9-30-05" coba normalisasi delimiter ke colon
            m = s.match(/^(\d{1,2})[.\-](\d{1,2})(?:[.\-](\d{1,2}))?$/);
            if (m) {
                let hh = parseInt(m[1],10);
                let mm = parseInt(m[2],10);
                let ss = m[3] ? parseInt(m[3],10) : 0;
                if (hh < 0 || hh > 23 || mm < 0 || mm > 59 || ss < 0 || ss > 59) return null;
                return String(hh).padStart(2,'0') + ':' + String(mm).padStart(2,'0') + ':' + String(ss).padStart(2,'0');
            }

            // fallback: invalid
            return null;
        }

        document.getElementById('saveBtn').addEventListener('click', function () {
            let sptbs = table.getData();
            const columns = ['angkutan','no_tiket','tanggal_tiket','no_sptbs','tanggal_sptbs','tanggal_panen','nama_supir',
                'no_polisi','jam_masuk','jam_keluar','estate','divisi','blok','tahun_tanam','lahan','jumlah_tandan','berondolan',
                'berat_bruto','berat_tarra','berat_netto','jumlah_grading','berat_bersih','bjr'];
            const payload = sptbs
                .filter(row => row.some(cell => cell !== null && String(cell).trim() !== ''))
                .map(row => {
                    let obj = {};
                    columns.forEach((col, i) => {
                        let value = row[i] ?? null;
                        if (col === 'jam_masuk' || col === 'jam_keluar') {
                            value = normalizeTimeToHHMMSS(value);
                        }
                        // Convert comma to dot for numeric fields
                        if (['berondolan', 'berat_bruto', 'berat_tarra', 'berat_netto', 'jumlah_grading', 'berat_bersih', 'bjr'].includes(col) && value !== null) {
                            value = String(value).replace(',', '.');
                        }
                        obj[col] = value;
                    });
                    return obj;
                });

            fetch("{{ route('sptbs.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ sptbs: payload })
            })
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                alert(data.message ?? 'Data berhasil disimpan');
                window.location.href = '{{ route("sptbs.index") }}';
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi error saat menyimpan. Cek console.');
            });
        });

    });
    </script>
@endpush