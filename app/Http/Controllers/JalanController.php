<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class JalanController extends Controller
{
    public function index()
    {
        return view('dashboard.jalan');
    }
}
