<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Repository\MensagemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class MensagemController extends Controller
{

    public function __construct(Mensagem $mensagem)
    {
        $this->mensagem = $mensagem;
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd(Auth::user()->id);
        //return view('app.chat');
        $mensagemRepository = new MensagemRepository($this->mensagem);
        // dd($this->user);
        $mensagemRepository->setRelacionamento('user');
        
        if($request->has('usuario_autenticado')){
         //Filtrar mensagens que foram enviadas pelo mesmo usuário autenticado;
         $mensagemRepository->filtrarRegistros('de_user_id:=:'.Auth::user()->id);
        }

        if($request->has('atributos')) {
            $mensagemRepository->selectAtributos($request->atributos);
        }

        if($request->has('atributos_relacionamento')) {
            // dd($request->atributos_relacionamento);
            
            $mensagemRepository->selectAtributosRelacionamento($request->atributos_relacionamento);

        }

        if($request->has('filtro')) {
            $mensagemRepository->filtrarRegistros($request->filtro);
        }

        if($request->has('getMessages')) {
            $user = new \App\Models\User;
            $userRepository = new \App\Repository\UserRepository($user);
            
            $userRepository->getMensagem($request->getMessages);

            return response()->json($userRepository->getRes(),200);

        }
       
        

        return response()->json($mensagemRepository->getRes(),200);

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
        $this->mensagem->desc_mensagem = $request->desc_mensagem;
        $this->mensagem->de_user_id = $request->de_usuario_id;
        $this->mensagem->para_user_id = $request->para_usuario_id;
        // $this->mensagem->created_at = \Carbon\Carbon::now()->format('d/m/Y');
        $this->mensagem->save();

        return response()->json('Mensagem enviada com sucesso!',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function edit(Mensagem $mensagem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensagem $mensagem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mensagem $mensagem)
    {
        //
    }
}
