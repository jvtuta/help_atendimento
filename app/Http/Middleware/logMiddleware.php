<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Logs;

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
        $log = new Logs();
        $log->desc_logs = $desc_log;
        $log->save();
        return $next($request);
    }
}
