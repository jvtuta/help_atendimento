<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;




class AuthController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request) 
    {

        
        $token = auth('api')->attempt($request->all('nome_usuario','password'));
        
        
        if($token) {    
            
            return response()->json(['token'=>$token],200);
        } else {
            return response()->json(['Erro'],404);
        }
        
    }
    public function register(Request $request)
    {
        /*Validar as entradas antes de salvar o usuário a fim de manter consistência*/
        if($request->password == $request->password_confirmation) {
            $this->user->fill($request->all());
            $this->user->password = bcrypt($request->get('password'));
            $token = auth('api')->attempt($request->all('nome_usuario','password'));
            if($this->user->save()&&$token) {
                return response()->json(['Sucesso'=>'Usuário cadastrado com sucesso','token'=>$token],201);
            };
            return response()->json(['Erro'=>'Erro ao salvar'],400);
        }   
        return response()->json(['Erro'=>'Confirmação da senha inválida'],401);
        


        
        // return 'teste registrar';
    }
    public function logout() 
    {
        return 'teste logout';
    }
    public function me() 
    {
        return response()->json(['Usuário'=>auth('api')->user()]);
    }
    public function refresh() 
    {
        return 'teste refresh';
    }
}
