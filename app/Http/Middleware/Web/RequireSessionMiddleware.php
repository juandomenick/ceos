<?php

namespace App\Http\Middleware\Web;

use Closure;

// SERVICES
use App\Http\Services\Session\Login\LoginServices;
use Illuminate\Support\Facades\Route;

class RequireSessionMiddleware
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
        $services_login = new LoginServices;

        // VALIDA O LOGIN DO USUÁRIO
        $login = $services_login->validar();

        // VERIFICA SE O SERVIÇO CONSTATOU O LOGIN DO USUÁRIO
        if ($login['resposta'] == 'sucesso') {
            return $next($request);
        } else {
            return redirect()->route('web.plataforma.login')
                ->with(Route::currentRouteName() != 'home' ? ['atencao' => $login['mensagem']] : []);
        }
    }
}
