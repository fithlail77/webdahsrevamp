<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PupukRawatController extends Controller
{
    public function index()
    {
        return view('dashboard.pr');
    }
}
