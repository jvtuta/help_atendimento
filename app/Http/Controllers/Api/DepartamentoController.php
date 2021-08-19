<?php

namespace App\Http\Controllers\Api;

use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Repository\DepartamentoRepository;

class DepartamentoController extends Controller
{
    public function __construct(Departamento $departamento)
    {
        $this->departamento = $departamento;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departamentoRepository = new DepartamentoRepository($this->departamento);
        $departamentoRepository->setRelacionamento('users');
        if ($request->has('atributos')) {
            $departamentoRepository->selectAtributos($request->atributos);
        }

        if ($request->has('atributos_relacionamento')) {

            
            $departamentoRepository->selectAtributosRelacionamento($request->atributos_relacionamento);
        }

        if ($request->has('filtro')) {
            $departamentoRepository->filtrarRegistros($request->filtro);
        }
        
        return response()->json($departamentoRepository->getRes(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        //
    }
}
