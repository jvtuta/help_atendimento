<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function index() {
        return view('app.configuracoes');
    }
}
