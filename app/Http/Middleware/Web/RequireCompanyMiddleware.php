<?php

namespace App\Http\Middleware\Web;

use Closure;

// SERVICES
use App\Http\Services\Session\Contratantes\ContratantesServices;

class RequireCompanyMiddleware
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
        // SERVICES
        $services_contratantes = new ContratantesServices;

        // VALIDA O CONTRATANTE DO USUÁRIO
        $contratante = $services_contratantes->validar();

        // VERIFICA SE O SERVIÇO CONSTATOU O CONTRATANTE DO USUÁRIO
        if ($contratante['resposta'] == 'sucesso') {
            return $next($request);
        } else {
            return redirect()->route('login.contratantes.selecionar')
                ->with([
                    'informacao' => ['Essa informação pode ser alterada posteriormente'],
                    'atencao' => $contratante['mensagem'],
                ]);
        }
    }
}
