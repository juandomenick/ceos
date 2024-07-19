<?php

namespace App\Http\Middleware\Api;

use Closure;

// SERVICES
use App\Models\Logs\Geral\Login as LogsLogin;

class TokenUserMiddleware
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
        // SERVICE
        $logs_login = new LogsLogin;

        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        // VALIDA O TOKEN
        if ($request->header('TokenUser')) {
            return $next($request);
            // CONSULTA O CONTRATANTE PELO TOKEN
            // $consulta = $logs_login->consultar_services_logins([
            //     'Token' => $request->header('TokenUser')
            // ]);

            // // VERIFICA SE O SERVIÇO CONSTATOU O LOGIN
            // if ($retorno = $logs_login->consultar_services_logins([
            //     'Token' => $request->header('TokenUser')
            // ])) {
            //     // SEGUE O PROCESSO
            //     return $next($request);
            // } else {
            //     $resposta = "erro";
            //     $mensagem[] = "Token do Usuário (TokenUser) inválido";
            //     $dados = $request->all();
            // }
        } else {
            $resposta = "erro";
            $mensagem[] = 'Token do Usuário "TokenUser" não enviado corretamente';
            $dados = $request->all();
        }

        // RETORNO CASO TIVER ERRO
        return response()->json(['resposta' => $resposta, 'mensagem' => $mensagem, 'dados' => $dados]);
    }
}
