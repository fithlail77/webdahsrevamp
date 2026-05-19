<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LoginLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vloginlogs.index');
    }

    /**
     * Ajax DataTables source.
     */
    public function data(Request $request)
    {
        $query = LoginLog::with(['user'])
            ->select(['id', 'user_id', 'ip_address', 'user_agent', 'logged_in_at'])
            ->orderBy('logged_in_at', 'desc');

        // Filter tanggal
        if ($request->minDate && $request->maxDate) {
            $query->whereBetween('logged_in_at', [$request->minDate . ' 00:00:00', $request->maxDate . ' 23:59:59']);
        } elseif ($request->minDate) {
            $query->whereDate('logged_in_at', '>=', $request->minDate);
        } elseif ($request->maxDate) {
            $query->whereDate('logged_in_at', '<=', $request->maxDate);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('user_id', function (LoginLog $row) {
                return $row->user?->name ?? '-';
            })
            ->editColumn('user_agent', function (LoginLog $row) {
                return $row->user_agent ? Str::limit($row->user_agent, 60) : '-';
            })
            ->editColumn('logged_in_at', function (LoginLog $row) {
                return $row->logged_in_at
                    ? Carbon::parse($row->logged_in_at)->format('d-m-Y H:i:s')
                    : '-';
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->input('search.value'))) {
                    $search = $request->input('search.value');
                    $query->where(function ($q) use ($search) {
                        $q->whereHas('user', function ($uq) use ($search) {
                            $uq->where('name', 'like', "%{$search}%");
                        })
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhere('user_agent', 'like', "%{$search}%");
                    });
                }
            })
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
        //
    }
}
