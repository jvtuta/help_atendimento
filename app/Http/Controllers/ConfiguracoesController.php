<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function __construct() {
        $this->middleware('nivel.usuario:gerente,all');
    }

    public function index() {
        return view('app.configuracoes');
    }
}
