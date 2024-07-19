<?php

namespace App\Http\Controllers\Web\Sessao;

// SERVICES
use App\Http\Services\Session\Login\LoginServices;

// BIBLIOTECAS
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * __construct - função chamada na instancia da classe
     */
    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * index - tela e método de login da plataforma
     *
     * @method GET | POST
     * @param Request
     * @return view | redirect
     */
    public function index(Request $request)
    {
        if ($request->method() == 'GET') {
            // TODA VEZ QUE ENTRA NA TELA DE LOGIN SETA O AMBIENTE DE PRODUÇÃO
            session()->forget('login');

            // VIEW
            return view('web.plataforma.sessao.login.index');
        } else {
            // SETA O BANCO
            session()->put('connection', 'local');

            // SERVICES
            $services_login = new LoginServices;

            // EFETUA O SERVICO DE LOGIN
            $login = $services_login->setar($request->all());

            // VALIDA O SERVIÇO
            if ($login['resposta'] == 'sucesso') {
                return redirect()->route('web.plataforma.home')
                    ->with($login['dados']['feedbacks']);
            } else {
                return redirect()->route('web.plataforma.login')
                    ->withInput($request->all())
                    ->withErrors($login['dados']['feedbacks']['erro']);
            }
        }
    }

    /**
     * index - tela e método de login da plataforma
     *
     * @method GET
     * @param Request
     * @return view | redirect
     */
    public function logout(Request $request)
    {
        // EFETUA O LOGOUT
        session()->forget('db');
        session()->forget('login');

        // REDIRECIONAMENTO
        return redirect()->route('web.plataforma.login');
    }
}
