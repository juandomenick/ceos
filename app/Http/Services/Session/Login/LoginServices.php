<?php

namespace App\Http\Services\Session\Login;

// SERVICES
use App\Http\Services\Acessos\Pessoas\PessoasServices;

// BIBLIOTECAS
use App\Http\Services\Service;
use Illuminate\Support\Facades\Validator;

class LoginServices extends Service
{
    /**
     * __construct - função chamada na instancia da classe
     */
    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * validar - método que valida se o usuário está logado
     *
     * @param null
     * @return array ['resposta', 'mensagem', 'dados']
     */
    public function validar()
    {
        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        // VALIDA SE O USUÁRIO ESTÁ LOGADO
        if (session()->has('login')) {
            $resposta = 'sucesso';
            $mensagem[] = 'Usuário com login validado';
            $dados = session()->get('login');
        } else {
            // SE NÃO ESTIVER
            $resposta = 'erro';
            $mensagem[] = 'Acesse sua conta para continuar';
        }

        // RETORNO
        return ["resposta" => $resposta, "mensagem" => $mensagem, "dados" => $dados];
    }

    /**
     * setar - método que efetua o login do usuário conforme os parametros
     *
     * @param array $parametros
     * @return array ['resposta', 'mensagem', 'dados']
     */
    public function setar(array $parametros)
    {
        // SERVICES
        $services_pessoas = new PessoasServices;

        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        // REGRAS DE VALIDAÇÃO
        $regras = [
            'Acesso' => ['required'],
            'Senha' => ['required'],
        ];

        // MENSAGENS DE RETORNO DE VALIDAÇÃO
        $feedback = [
            'Acesso.required' => 'O campo "Acesso" é obrigatório',
            'Senha.required' => 'O campo "Senha" é obrigatório',
        ];

        // VALIDAÇÃO
        $validator = Validator::make($parametros, $regras, $feedback);

        // VALIDA SE TEM ERROS
        if (!$validator->fails()) {
            // CONSULTA O USUÁRIO
            $consulta_pessoa = $services_pessoas->consultar([
                'Colunas' => [
                    'Base' => true
                ],
                'Filtros' => [
                    'Base' => [
                        'Acesso' => $parametros['Acesso']
                    ]
                ],
                'Ordenacao' => [
                    'Campo' => 'Nome',
                    'Ordem' => 'ASC',
                ],
                'Limite' => [],
            ]);

            // VALIDA A CONSULTA;
            if ($consulta_pessoa['resposta'] == 'sucesso') {
                // ATRIBUI O VALOR DA CONSULTA
                $pessoa = (array) $consulta_pessoa['dados']->first();

                // VALIDA A SENHA DO USUÁRIO
                if (password_verify($parametros['Senha'], $pessoa['SenhaPessoa'])) {
                    // VALIDA O STATUS DO USUÁRIO
                    if (in_array($pessoa['StatusPessoa'], ['Ativo'])) {
                        // SETANDO TOKEN
                        $pessoa['Token'] = mb_strtoupper(bin2hex(random_bytes(15)));

                        // CRIA A SESSION
                        session()->put('login', $pessoa);

                        // SUCESSO
                        $resposta = 'sucesso';
                        $mensagem[] = 'Olá "' . $pessoa['NomePessoa'] . '", seja bem vindo ao "' . env('APP_NAME') . '"!';
                        $dados['feedbacks']['sucesso'] = $mensagem;
                        $dados['login'] = $pessoa;
                    } else {
                        // DESTROI A SESSION
                        session()->forget('login');

                        // RETORNA ERRO
                        $resposta = "erro";
                        $mensagem[] = 'Usuário está no Status "' . $pessoa['StatusPessoa'] . '", entre em contato com seu Administrador';
                        $dados['feedbacks']['erro'] = $mensagem;
                    }
                } else {
                    // DESTROI A SESSION
                    session()->forget('login');

                    // RETORNA ERRO
                    $resposta = 'erro';
                    $mensagem[] = 'Usuário ou senha inválido(s) 2';
                    $dados['feedbacks']['erro'] = $mensagem;
                }
            } else {
                // DESTROI A SESSION
                session()->forget('login');

                // RETORNA ERRO
                $resposta = 'erro';
                $mensagem[] = 'Usuário ou senha inválido(s)';
                $dados['feedbacks']['erro'] = $mensagem;
            }
        } else {
            $resposta = "erro";
            $mensagem = $validator->errors()->all();
            $dados['feedbacks']['erro'] = $validator->errors();
        }

        // RETORNO
        return ["resposta" => $resposta, "mensagem" => $mensagem, "dados" => $dados];
    }
}
