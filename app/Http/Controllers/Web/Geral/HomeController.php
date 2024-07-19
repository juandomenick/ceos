<?php

namespace App\Http\Controllers\Web\Geral;

// BIBLIOTECAS
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * __construct - função chamada na instancia da classe
     */
    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * index - tela e método da home page da plataforma
     *
     * @method GET | POST
     * @param Request
     * @return view | redirect
     */
    public function index()
    {
        // VARIÁVEIS DA VIEW
        $data['view'] = [
            'titulo' => 'CEOS',
            'icone' => 'home',
            'descricao' => 'Comunidade Escolar Online Simplificada',
        ];

        // VIEW
        return view('web.plataforma.home.index', $data);
    }
}
