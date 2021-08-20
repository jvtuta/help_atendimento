<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MetasImport;

class MetaController extends Controller
{
    public function index() {
        return view('app.meta');
    }

    public function meta_import(Request $request) {
        
        Excel::import(new MetasImport(), $request->file('meta'));
        return view('app.meta');
    }
}
