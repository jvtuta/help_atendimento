<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Departamento;


use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class NivelUsuarioMiddleware
{

    public function handle(Request $request, Closure $next, $nivel_usuario, $departamento)
    {   
        
        $departamento = Departamento::where('nome_departamento', strtolower($departamento))->get();
        if(Auth::user()->nivel_usuario == strtolower($nivel_usuario) &&
          Auth::user()->id_departamento == $departamento->id ||
          Auth::user()->administrador == 1 ) {
            return $next($request);
        }
        
        return redirect('app/home');
    }
}
