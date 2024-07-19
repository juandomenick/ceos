<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;

class RequireBrowserMiddleware
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
        // RESGATA O HEADER
        $userAgent = $request->header('User-Agent');

        // VERIFICA SE O USUÁRIO ESTÁ ACESSANDO VAI NAVEGADOR
        if (preg_match('/Chrome|Firefox|Mozilla|Safari|Edge|Opera/', $userAgent)) {
            return $next($request);
        }

        // SE NÃO ESTIVER ACESSANDO VIA NAVEGADOR, ELE RECEBE UM ERRO EM JSON
        return response([
            "resposta" => 'erro',
            "mensagem" => ['O acesso ao WMS só pode ser feito via navegador'],
            "dados" => 403
        ], 403)->header("Content-Type", "application/json");
    }
}
