<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userRepository = new UserRepository($this->user);
        
        if($request->has('usuario_autenticado') )
        {
            $userRepository->filtrarRegistros('id:=:'.Auth::user()->id);
        }
        
        if($request->has('atributos')) {
            $userRepository->selectAtributos($request->atributos);
        }
        
        if($request->has('atributos_relacionamento')) {
            
            if($request->relacionamento=='departamento') {
                $userRepository->setRelacionamento('departamento');
                $userRepository->selectAtributosRelacionamento($request->atributos_relacionamento);
            } else {
                $userRepository->setRelacionamento('mensagens');
                $userRepository->selectAtributosRelacionamento($request->atributos_relacionamento);
            }
        } 

        if($request->has('filtro')) {
            $userRepository->filtrarRegistros($request->filtro);
        }

        if($request->has('usuarios')) {
            return response()->json(['usuarios'=>$userRepository->getRes(), 'usuario_autenticado'=>Auth::user()], 200);
        }

        if($request->has('usuario_autenticado')) {
            return response()->json(["query"=>$userRepository->getRes(),'usuario_autenticado'=>Auth::user()->id], 200);
        } else {
            return response()->json($userRepository->getRes(),200);
        }
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
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        if(!$user) {
            return response()->json(['erro' => 'Recurso não existe'], 404);
        }
        $user->fill($request->all());
        $user->save();
        return response()->json(['sucesso' => 'Recurso salvo com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        //
    }
}
