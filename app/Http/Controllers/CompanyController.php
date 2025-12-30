<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
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
        return view('comp.index', compact('estate','divisi'));
    }

    public function data(Request $request)
    {
        $query = Company::select([
            'id',
            'kd_comp',
            'perusahaan',
            'kd_est',
            'estate',
            'divisi',
        ])
        ->orderBy('perusahaan','asc');

        // Filter berdasarkan estate user
        $userEstate = Auth::user()->estate ?? null;
        if ($userEstate && $userEstate !== 'all') {
            $query->where('estate', $userEstate);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                    <a href="#" class="btn btn-success btn-sm edit-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#modal-EditComp"><i class="fa fa-edit"></i></a>
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
        $request->validate([
            'kd_comp' => 'required',
            'perusahaan'=> 'required',
            'kd_est' => 'required',
            'estate' => 'required',
            'divisi' => 'required',
        ]);

        Company::create($request->all());
        return redirect()->route('comp.index')->with('success','Perusahaan berhasil ditambahkan.');
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
         try {
            $company = Company::findOrFail($id);
            return response()->json($company);
        } catch (\Exception $e) {
            Log::error('Error in edit Method: ' . $e->getMessage() . ' ID: ' . $id);
            return response()->json(['error' => 'Data tidak ditemukan: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'perusahaan'=> 'required|string|max:100',
            'kd_est' => 'required|string|max:5',
            'estate' => 'required|string|max:15',
            'divisi' => 'required|integer',
        ]);

        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
