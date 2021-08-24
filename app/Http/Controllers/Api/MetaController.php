<?php

namespace App\Http\Controllers\Api;

use App\Models\Meta;
use Illuminate\Http\Request;
use App\Imports\MetasImport;
use App\Repository\MetaRepository;
use Illuminate\Support\Facades\Auth;

class MetaController extends Controller
{
    public function __construct(Meta $meta) 
    {
        $this->meta = $meta;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        $metaRepository = new MetaRepository($this->meta);
        
        if($request->has('atributos')) {
            $metaRepository->selectAtributos($request->atributos);
        }
        
        if($request->has('atributos_relacionamento')) {
            $metaRepository->setRelacionamento('user');
        } 

        if($request->has('filtro')) {
            $metaRepository->filtrarRegistros($request->filtro);
        }

        if($request->has('meta_usuario')) {
            $metaRepository->repository->where('id','=',Auth::user()->id);
            
        }

        if($request->has('data')) {
            $metaRepository->repository->where('data',$request->data);
        }

        return response()->json($metaRepository->getRes(),200);
        
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function show(Meta $meta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function edit(Meta $meta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $meta = $this->meta->find($id);
        if(!$meta) {
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        $meta->fill($request->all());
        $meta->save();
        return response()->json(['sucesso' => 'Recurso salvo com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meta $meta)
    {
        //
    }
}
