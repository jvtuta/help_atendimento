<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;


class logMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        // Verificar se usuário está logado se sim atribuir a desc_logs o nome do usuário logado e a rota acesssada
        
        $rota = $request->path();
        $ip_cliente = $request->server->get('REMOTE_ADDR');
        $desc_log = 'O ip: '.$ip_cliente.' Acessou a rota: '.$rota;
        if(Auth::user()) {
            $desc_log = 'Usuario autenticado: '.Auth::user()->nome_usuario . 'Acessou a rota: ' .$rota. 'Pelo ip: '. $ip_cliente;
        }
        $log = new Logs();
        $log->desc_logs = $desc_log;
        $log->save();
        return $next($request);
    }
}
