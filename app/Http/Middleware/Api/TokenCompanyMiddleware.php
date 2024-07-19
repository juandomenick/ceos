<?php

namespace App\Http\Middleware\Api;

use Closure;

// SERVICES
use App\Http\Services\Cadastros\Catalogo\Acessos\Contratantes\ContratantesServices;

class TokenCompanyMiddleware
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
        $service_contratantes = new ContratantesServices;

        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        try {
            // VALIDA O TOKEN
            if ($request->header('TokenCompany')) {
                session()->put('database_core',  'core');

                // CONSULTA O CONTRATANTE PELO TOKEN
                $consulta = $service_contratantes->consultar([
                    'Colunas' => [
                        'Base' => true
                    ],
                    'Filtros' => [
                        'Base' => [
                            'ApiToken' => $request->header('TokenCompany'),
                        ]
                    ],
                    'Ordenacao' => [
                        'Campo' => 'Nome',
                        'Ordem' => 'ASC',
                    ],
                    'Limite' => [],
                ]);

                // VERIFICA SE O SERVIÇO CONSTATOU O CONTRATANTE
                if ($consulta['resposta'] == 'sucesso') {
                    // SETA O CONTRATANTE NA REQUISICAO PARA SEGUIR COM A REQUISIÇÃO
                    $request->merge(['idContratante' => $consulta['dados']->first()->CodigoSistema]);
                    // SEGUE O PROCESSO
                    return $next($request);
                } else {
                    $resposta = "erro";
                    $mensagem[] = 'Token do Contratante "TokenCompany" inválido ou não enviado';
                    $dados = $request->all();
                }
            } else {
                $resposta = "erro";
                $mensagem[] = 'Token do Contratante "TokenCompany" não enviado corretamente';
                $dados = $request->all();
            }
        } catch (\Exception $e) {
            $resposta = "erro";
            $mensagem[] = $e->getMessage();
            $dados = $request->all();
        }

        // RETORNO CASO TIVER ERRO
        return response()->json(['resposta' => $resposta, 'mensagem' => $mensagem, 'dados' => $dados]);
    }
}
