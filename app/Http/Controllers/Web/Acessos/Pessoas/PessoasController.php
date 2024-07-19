<?php

namespace App\Http\Controllers\Web\Acessos\Pessoas;

// SERVICES
use App\Http\Services\Acessos\Pessoas\PessoasServices;

// BIBLIOTECAS
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PessoasController extends Controller
{
    /**
     * __construct - função chamada na instancia da classe
     */
    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * listar - tela de listagem de pessoas
     *
     * @method GET
     * @param Request
     * @return view
     */
    public function listar(Request $request)
    {
        if ($request->method() == 'GET') {
            // VARIÁVEIS DA VIEW
            $data['view'] = [
                'titulo' => 'Pessoas',
                'icone' => 'acessos',
                'descricao' => 'Página da relação de todos os pessoas cadastrados',
                'breadcrumb' => [
                    ['Acessos', '#'],
                    ['Pessoas', route('web.plataforma.acessos.pessoas.listar')],
                    ['Listar', route('web.plataforma.acessos.pessoas.listar')],
                ],
            ];
            // VIEW
            return view('web.plataforma.acessos.pessoas.listar.index', $data);
        }
    }

    /**
     * cadastrar - tela e método de cadastro de pessoas
     *
     * @method GET | POST
     * @param Request
     * @return view | redirect
     */
    public function cadastrar(Request $request)
    {
        if ($request->method() == 'GET') {
            // VARIÁVEIS DA VIEW
            $data['view'] = [
                'titulo' => 'Cadastrar - Pessoa',
                'icone' => 'acessos',
                'descricao' => 'Página de cadastro de novos pessoas para acessar a plataforma',
                'breadcrumb' => [
                    ['Cadastros', '#'],
                    ['Acessos', '#'],
                    ['Pessoas', route('cadastros.acessos.usuarios.listar')],
                    ['Cadastrar', route('cadastros.acessos.usuarios.cadastrar')],
                ],
            ];

            // VIEW
            return view('web.cadastros.acessos.usuarios.cadastrar.index', $data);
        } else {
            // SERVICES
            $services_usuarios = new PessoasServices;

            // MERGES DE DADOS
            $request->merge(['idContratante' => session()->get('login.Contratante.CodigoSistema')]);
            $request->merge(['idPessoaNivel' => $this->securityHelper->decrypt($request->get('idPessoaNivel'))]);
            $request->merge(['Email' => $request->has('Email') ? mb_strtolower($request->get('Email')) : null]);
            $request->merge(['Acesso' => $request->has('Acesso') ? mb_strtolower($request->get('Acesso')) : null]);

            // EFETUA O SERVIÇO DE CRIAR O USUARIO
            $cadastrar_usuario = $services_usuarios->cadastrar($request->all());

            // VALIDA O SERVIÇO
            if ($cadastrar_usuario['resposta'] == 'erro') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors($cadastrar_usuario['dados']['feedbacks']['erro']);
            } else {
                return redirect()->route('cadastros.acessos.usuarios.listar')
                    ->with($cadastrar_usuario['dados']['feedbacks']);
            }
        }
    }

    /**
     * detalhes - tela e método dos detalhes de um determinado pessoa
     *
     * @method GET | POST
     * @param Request
     * @return view | redirect
     */
    public function detalhes(string $idPessoa, Request $request)
    {
        if ($request->method() == 'GET') {
            // SERVICES
            $services_usuarios = new PessoasServices;

            // CONSULTA O USUÁRIO COM O SERVICO
            $consulta_usuario = $services_usuarios->consultar([
                'Colunas' => [
                    'Base' => true,
                    'Nivel' => true,
                ],
                'Filtros' => [
                    'Base' => [
                        'idContratante' => session()->get('login.Contratante.CodigoSistema'),
                        'CodigoSistema' => $this->securityHelper->decrypt($idPessoa),
                    ]
                ],
                'Ordenacao' => [
                    'Campo' => 'Nome',
                    'Ordem' => 'ASC',
                ],
                'Limite' => [],
                'Listas' => [
                    'Contratantes' => true,
                ]
            ]);

            // SE CONSEGUIR ENCONTRAR, SEGUE COM A VIEW, SE NÃO VOLTA PRA LISTAGEM
            if ($consulta_usuario['resposta'] == 'sucesso') {
                // USUARIO
                $data['usuario'] = $consulta_usuario['dados']->first();
                $data['usuario']->CodigoSistemaCriptografado = $idPessoa;

                // VARIÁVEIS DA VIEW
                $data['view'] = [
                    'titulo' => "Detalhes - Pessoa - {$data['usuario']->NomePessoa}",
                    'icone' => 'acessos',
                    'descricao' => 'Página de detalhes do pessoa em questão',
                    'breadcrumb' => [
                        ['Cadastros', '#'],
                        ['Acessos', '#'],
                        ['Pessoas', route('cadastros.acessos.usuarios.listar')],
                        ['Detalhes', route('cadastros.acessos.usuarios.detalhes', [$idPessoa])],
                        [$data['usuario']->NomePessoa, route('cadastros.acessos.usuarios.detalhes', [$idPessoa])],
                    ],
                ];

                // VIEW
                return view('web.cadastros.acessos.usuarios.detalhes.index', $data);
            } else {
                // RETORNA PARA A LISTAGEM COM O FEEDBACK
                return redirect()->route('cadastros.acessos.usuarios.listar')
                    ->with([$consulta_usuario['resposta'] => $consulta_usuario['mensagem']]);
            }
        } else {
            // SERVICES
            $services_usuarios = new PessoasServices;

            // MERGES DE DADOS
            $request->merge(['idContratante' => session()->get('login.Contratante.CodigoSistema')]);
            $request->merge(['CodigoSistema' => $this->securityHelper->decrypt($idPessoa)]);
            $request->merge(['Email' => $request->has('Email') ? mb_strtolower($request->get('Email')) : null]);
            $request->merge(['Acesso' => $request->has('Acesso') ? mb_strtolower($request->get('Acesso')) : null]);

            // EFETUA O SERVIÇO DE CRIAR O USUARIO
            $editar_usuario = $services_usuarios->editar($request->all());

            // VALIDA O SERVIÇO
            if ($editar_usuario['resposta'] == 'erro') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors($editar_usuario['dados']['feedbacks']['erro']);
            } else {
                return redirect()->route('cadastros.acessos.usuarios.detalhes', [$idPessoa])
                    ->with($editar_usuario['dados']['feedbacks']);
            }
        }
    }
}
