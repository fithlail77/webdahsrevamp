<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ffbinternal;
use Illuminate\Http\Request;
use App\Imports\FfbinternalImport;
use App\Exports\FfbInternalExport;
use App\Exports\FfbInternalPdfExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class FfbInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$ffbint = Ffbinternal::where('tanggal', '>=', Carbon::now()->subDays(30))
        //->orderBy('tanggal', 'desc')
        //->get();

        //$start = Carbon::now()->startOfMonth();
        //$end = Carbon::now()->endOfMonth();

        // Generate semua tanggal dalam bulan
        //$tanggalLengkap = [];
        //$current = $start->copy();
        //while ($current <= $end) {
        //    $tanggalLengkap[$current->format('d')] = 0; // default value 0
        //    $current->addDay();
        //}

        //$data = DB::table('ffb_internal')
        //    ->selectRaw('DATE(tanggal) as tanggal, SUM(ton_bruto) AS netto_awal')
        //    ->whereBetween('tanggal', [$start, $end])
        //    ->groupByRaw('DATE(tanggal)')
        //    ->get()
        //    ->mapWithKeys(function ($item) {
        //        return [Carbon::parse($item->tanggal)->format('d') => (int) $item->netto_awal];
        //            })
        //    ->toArray();
        
        //$result = [];
        //    foreach ($tanggalLengkap as $tgl => $value) {
        //        $result[] = $data[$tgl] ?? 0;
        //}
        
        //$labels = array_keys($tanggalLengkap);
        //$data = $result;

        //return view('ffbint.index', compact('ffbint','labels', 'data'));

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $target = 445000;

        $tanggalLengkap = [];
        $current = $start->copy();
        while ($current <= $end) {
            $tanggalLengkap[$current->format('d')] = 0;
            $current->addDay();
        }

        $dataTonBruto = DB::table('ffb_internal')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(ton_bruto) as bruto, SUM(netto) as netto, SUM(grading) as grading')
            ->whereBetween('tanggal', [$start, $end])
            ->groupByRaw('DATE(tanggal)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    Carbon::parse($item->tanggal)->format('d') => [
                        'bruto' => (int) $item->bruto,
                        'netto' => (int) $item->netto,
                        'grading' => (int) $item->grading
                    ]
                ];
            })->toArray();

        $labels = array_keys($tanggalLengkap);
        $bruto = [];
        $netto = [];
        $grading = [];

        foreach ($labels as $tgl) {
            $brutoVal = $dataTonBruto[$tgl]['bruto'] ?? 0;
            $nettoVal = $dataTonBruto[$tgl]['netto'] ?? 0;
            $gradingVal = $dataTonBruto[$tgl]['grading'] ?? 0;
            $bruto[] = $brutoVal;
            $netto[] = $nettoVal;
            $grading[] = ($brutoVal > 0) ? round(($gradingVal / $brutoVal) * 100, 2) : 0;
        }

        return view('ffbint.index', compact('labels', 'bruto', 'netto', 'grading', 'target'));
    }

    public function data(Request $request)
    {
        $query = Ffbinternal::select([
            'id',
            'no_po',
            'vendor_detail',
            'tanggal',
            'time_in',
            'time_out',
            'no_plat',
            'driver',
            'bruto_awal',
            'tarra',
            'ton_bruto',
            'grading',
            'netto',
            'jml_tandan',
            'bjr',
            'estate',
            'divisi',
            'asal_tbs',
        ])
        ->orderBy('tanggal','desc');

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
            ->addColumn('tanggal_formatted', function ($row) {
                return \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y');
            })
             ->addColumn('tanggal_formatted1', function ($row) {
                return \Carbon\Carbon::parse($row['bulan'])->format('d-m-Y');
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditFfbInternal"><i class="fa fa-edit"></i></a>
                ';
            })
            ->rawColumns(['aksi'])
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $ffbint = Ffbinternal::findOrFail($id);
        $ffbint->delete();
        return redirect()->route('ffbinternal.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        Excel::import(new FfbinternalImport, $request->file('file'));

        return redirect()->route('ffbinternal.index')->with('success', 'Data berhasil diupload.');
    }

    public function exportExcel(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        return Excel::download(new FfbInternalExport($minDate, $maxDate, $search), 'FFB_Internal.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $minDate = $request->input('minDate');
        $maxDate = $request->input('maxDate');
        $search = $request->input('search');

        $pdfExport = new FfbInternalPdfExport($minDate, $maxDate, $search);
        return $pdfExport->generatePdf();
    }
}
