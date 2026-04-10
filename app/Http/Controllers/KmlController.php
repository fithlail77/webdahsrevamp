<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Kml;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KmlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estate = Company::select('estate')
            ->distinct()
            ->get();

        $divisi = Company::select('divisi')
            ->distinct()
            ->orderBy('divisi','asc')
            ->get();

        return view('kml.index', compact('estate', 'divisi'));
    }

    public function data(Request $request)
    {
        $query = Kml::select([
            'id',
            'nama_asisten',
            'estate',
            'divisi',
            'tanggal',
            'name',
            'path',
            'uploaded_at'
        ])
        ->orderBy('tanggal', 'desc');

         // Jika ada pencarian global, ambil semua data tanpa filter tanggal
        if (!empty($request->input('search.value'))) {
            // Tidak ada filter tanggal, ambil semua
        } else {
            // Jika ada filter tanggal, gunakan itu
            if($request->minDate && $request->maxDate) {
                $query->whereBetween('tanggal', [$request->minDate, $request->maxDate]);
            } elseif ($request->minDate) {
                $query->whereDate('tanggal', '>=', $request->minDate);
            } elseif ($request->maxDate) {
                $query->whereDate('tanggal', '<=', $request->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal', '>=', Carbon::now()->subDays(30));
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->setRowId('id')
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y');
            })
            ->addColumn('track', function ($row) {
                return '<a href="' . route('kml.show', $row['id']) . '" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Lihat Track</a>';
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditFfbInternal"><i class="fa fa-edit"></i></a>
                ';
            })
            ->rawColumns(['track', 'aksi'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi dasar (tanpa mimes)
        $request->validate([
            'tanggal' => 'required|date',
            'nama_asisten' => 'required|string|max:255',
            'estate' => 'required|string|max:30',
            'divisi' => 'required|string|max:10',
            'kml_file' => 'required|file|max:10240', // max 10MB
        ]);

        // 2. Pengecekan Ekstensi File secara Manual (Sangat ampuh untuk file GIS)
        $file = $request->file('kml_file');
        $extension = $file->getClientOriginalExtension();
        
        if (!in_array(strtolower($extension), ['kml', 'xml'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal: File yang diupload harus berekstensi .kml atau .xml');
        }

        try {
            // 3. Proses penyimpanan file
            $path = $file->store('kml', 'public');

            Kml::create([
                'tanggal' => $request->tanggal,
                'nama_asisten' => $request->nama_asisten,
                'estate' => $request->estate,
                'divisi' => $request->divisi,
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'uploaded_at' => now(),
            ]);

            return redirect()->route('kml.index')->with('success', 'Data KML berhasil di upload.');
        } catch (\Exception $e) {
            return redirect()->route('kml.index')->with('error', 'Gagal upload KML: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kmlFile = Kml::findOrFail($id);
        $startTime = null;
        $endTime = null;
        // Parse KML and get coordinates
        $coordinates = $this->parseKml($kmlFile->path);
        if (!empty($coordinates)) {
            $startTimeRaw = $coordinates[0]['time'] ?? null;
            $endTimeRaw = end($coordinates)['time'] ?? null;

            $startTime = $startTimeRaw
                ? Carbon::parse($startTimeRaw)->format('d-m-Y H:i:s')
                : null;

            $endTime = $endTimeRaw
                ? Carbon::parse($endTimeRaw)->format('d-m-Y H:i:s')
                : null;
        }

        return view('kml.show', compact(
            'kmlFile',
            'coordinates',
            'startTime',
            'endTime'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //private function parseKml($path)
    //{
    //    $content = Storage::disk('public')->get($path);
    //    $xml = simplexml_load_string($content);
    //    $coordinates = [];
//
    //    // Register gx namespace
    //    $xml->registerXPathNamespace('gx', 'http://www.google.com/kml/ext/2.2');
//
    //    // Parse gx:Track elements
    //    $tracks = $xml->xpath('//gx:Track');
    //    foreach ($tracks as $track) {
//
    //        // Ambil semua when tanpa peduli namespace
    //        $whens = $track->xpath('*[local-name()="when"]');
    //        $coords = $track->xpath('gx:coord');
//
    //        for ($i = 0; $i < count($coords); $i++) {
//
    //            $parts = explode(' ', trim((string)$coords[$i]));
//
    //            if (count($parts) >= 2) {
//
    //                $coordinates[] = [
    //                    'lat' => (float)$parts[1],
    //                    'lng' => (float)$parts[0],
    //                    'time' => isset($whens[$i]) ? (string)$whens[$i] : null
    //                ];
    //            }
    //        }
    //    }
//
    //    // Fallback to traditional LineString or Point if no tracks found
    //    if (empty($coordinates)) {
    //        foreach ($xml->Document->Placemark as $placemark) {
    //            if (isset($placemark->LineString)) {
    //                $coords = explode(' ', trim($placemark->LineString->coordinates));
    //                foreach ($coords as $coord) {
    //                    $parts = explode(',', $coord);
    //                    if (count($parts) >= 2) {
    //                        $coordinates[] = ['lat' => (float)$parts[1], 'lng' => (float)$parts[0]];
    //                    }
    //                }
    //            } elseif (isset($placemark->Point)) {
    //                $parts = explode(',', trim($placemark->Point->coordinates));
    //                if (count($parts) >= 2) {
    //                    $coordinates[] = ['lat' => (float)$parts[1], 'lng' => (float)$parts[0]];
    //                }
    //            }
    //        }
    //    }
//
    //    return $coordinates;
    //}

    private function parseKml($path)
    {
        $content = Storage::disk('public')->get($path);
        $xml = simplexml_load_string($content);
        $coordinates = [];

        if ($xml === false) {
            return $coordinates; // Kembalikan kosong jika file XML/KML corrupt
        }

        // Register gx namespace untuk tracking Google Earth
        $xml->registerXPathNamespace('gx', 'http://www.google.com/kml/ext/2.2');

        // 1. Coba parse elemen gx:Track (Format record track real-time)
        $tracks = $xml->xpath('//gx:Track');
        if (!empty($tracks)) {
            foreach ($tracks as $track) {
                $whens = $track->xpath('*[local-name()="when"]');
                $coords = $track->xpath('gx:coord');

                for ($i = 0; $i < count($coords); $i++) {
                    $parts = explode(' ', trim((string)$coords[$i]));
                    if (count($parts) >= 2) {
                        $coordinates[] = [
                            'lat' => (float)$parts[1],
                            'lng' => (float)$parts[0],
                            'time' => isset($whens[$i]) ? (string)$whens[$i] : null
                        ];
                    }
                }
            }
        }

        // 2. Fallback ke LineString (Format Avenza Export / Manual Draw)
        // Menggunakan local-name() agar bisa menembus segala Folder dan Namespace
        if (empty($coordinates)) {
            $lineStrings = $xml->xpath('//*[local-name()="LineString"]/*[local-name()="coordinates"]');
            
            if (!empty($lineStrings)) {
                foreach ($lineStrings as $ls) {
                    // Bersihkan enter, tab, dan spasi ganda menjadi 1 spasi tunggal
                    $coordString = preg_replace('/\s+/', ' ', trim((string)$ls));
                    $coordsArray = explode(' ', $coordString);

                    foreach ($coordsArray as $coord) {
                        $parts = explode(',', $coord);
                        if (count($parts) >= 2) {
                            $coordinates[] = [
                                'lat' => (float)$parts[1],
                                'lng' => (float)$parts[0]
                            ];
                        }
                    }
                }
            }
        }

        // 3. Fallback ke Point (Jika isinya ternyata cuma titik)
        if (empty($coordinates)) {
            $points = $xml->xpath('//*[local-name()="Point"]/*[local-name()="coordinates"]');
            if (!empty($points)) {
                foreach ($points as $pt) {
                    $coordString = preg_replace('/\s+/', ' ', trim((string)$pt));
                    $parts = explode(',', $coordString);
                    if (count($parts) >= 2) {
                        $coordinates[] = [
                            'lat' => (float)$parts[1],
                            'lng' => (float)$parts[0]
                        ];
                    }
                }
            }
        }

        return $coordinates;
    }
}
