<?php

namespace App\Http\Middleware;

use Closure;
use App\LogAcesso;

class LogAcessoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip = $request->server->get('REMOTE_ADDR');
        $rota = $request->getRequestUri('requestUri');
        LogAcesso::create(['log' => "IP $ip requisitou a rota $rota"]);
        //return $next($request);
        
        $resposta = $next($request);

        $resposta->setStatusCode(201, 'O status da resposta foi modificado.');
        return $resposta;

        //return Response('Chegamos no middleware e finalizamos no próprio');
    }
}
