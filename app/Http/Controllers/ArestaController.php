<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class ArestaController extends Controller
{
    public function index()
    {
        return view('dashboard.aresta');
    }

}
