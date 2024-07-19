<?php

namespace App\Http\Services\Acessos\Pessoas;

// SERVICES
use App\Http\Services\Acessos\Contratantes\ContratantesServices;

// MODELS
use App\Models\Acessos\Pessoas\PessoasModel;

// BIBLIOTECAS
use App\Http\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\FiltroPalavrasInapropriadas as FPI;

class PessoasServices extends Service
{
    /**
     * __construct - função chamada na instancia da classe
     */
    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * consultar - método que recebe os parametros e puxa usuários conforme os mesmos
     *
     * @param array $parametros
     * @return array ['resposta', 'mensagem', 'dados']
     */
    public function consultar(array $parametros): array
    {
        // MODELS
        $model_pessoas = new PessoasModel;

        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        // REGRAS DE VALIDAÇÃO
        $regras = [];

        // MENSAGENS DE RETORNO DE VALIDAÇÃO
        $feedback = [];

        // EXECUTA A VALIDAÇÃO
        $validator = Validator::make(@$parametros, $regras, $feedback);

        // VALIDA SE TEM ERROS
        if (!$validator->fails()) {
            // FAZ A CONSULTA
            $consulta = $model_pessoas->consultar_pessoas(
                @$parametros['Colunas'],
                @$parametros['Filtros'],
                @$parametros['Ordenacao'],
                @$parametros['Limite'],
            );
            // RETORNOS
            $resposta = $consulta['resposta'];
            $mensagem = array_merge($mensagem ?? [], $consulta['mensagem']);
            // VALIDA A CONSULTA
            if ($consulta['resposta'] == 'sucesso') {
                // SETANDO OS DADOS DE RETORNO
                $dados = $consulta['dados'];
                // VALIDA SE O CODIGO DO SISTEMA FOI CHAMADO PARA CRIPTOGRAFAR
                if (isset($dados->first()->CodigoSistema)) {
                    // PERCORRE O RETORNO
                    foreach ($dados as $i => $value) {
                        // E ADICIONA O ID CRIPTOGRAFADO DENTRO DE CADA ITEM
                        $dados[$i]->CodigoSistemaCriptografado = $this->securityHelper->encrypt($dados[$i]->CodigoSistema);

                        // LISTAS
                        foreach ($parametros['Listas'] ?? [] as $lista => $val) {
                            switch (mb_strtoupper($lista)) {
                            }
                        }
                    }
                }
            }
        } else {
            // RETORNOS
            $resposta = "erro";
            $mensagem = $validator->errors()->all();
            $dados['feedbacks']['erro'] = $validator->errors();
        }

        // RETORNO
        return ["resposta" => $resposta, "mensagem" => $mensagem, "dados" => $dados];
    }

    /**
     * cadastrar - método que recebe os parametros e cadastra um novo usuário
     *
     * @param array $parametros
     * @return array ['resposta', 'mensagem', 'dados']
     */
    public function cadastrar(array $parametros): array
    {
        // MODELS
        $model_pessoas = new PessoasModel;

        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        // REGRAS DE VALIDAÇÃO
        $regras = [
            'idContratante' => ['required'],
            'Nome' => ['required', 'max:255', 'min:3', 'regex:/^(?:[\p{L}\p{N}\s\-\/\(\)\.\çÇ]+)$/u', new FPI],
            'Email' => ['nullable', 'email', 'max:255', 'min:3', new FPI],
            'Acesso' => ['required', 'regex:/^[a-z0-9.]*$/', new FPI],
            'Status' => ['required'],
            'Senha' => ['required', 'max:20', 'min:3', new FPI],
            'ConfirmarSenha' => ['required', Rule::in([$parametros['Senha']])],
            'Contratantes' => ['required', 'array']
        ];

        // MENSAGENS DE RETORNO DE VALIDAÇÃO
        $feedback = [
            'idContratante.required' => 'O campo "Contratante" do Usuario é obrigatório',
            'Nome.required' => 'O campo "Nome" do Usuário é obrigatório',
            'Nome.min' => 'O campo "Nome" do Usuário deve ter pelo menos 3 caracteres',
            'Nome.max' => 'O campo "Nome" do Usuário deve ter até 255 caracteres',
            'Nome.regex' => 'O campo "Nome" do Usuário deve ter apenas "letras", "números", e os seguintes caracteres especiais "/ - . ( )"',
            'Email.email' => 'O campo "Email" do Usuário deve ser um E-mail válido',
            'Email.min' => 'O campo "Email" do Usuário deve ter pelo menos 3 caracteres',
            'Email.max' => 'O campo "Email" do Usuário deve ter até 255 caracteres',
            'Acesso.required' => 'O campo "Acesso" do Usuário é obrigatório',
            'Acesso.regex' => 'O campo "Acesso" do Usuário deve ter apenas "letras", "números" e "pontos"',
            'Status.required' => 'O campo "Status" do Usuário é obrigatório',
            'Senha.required' => 'O campo "Senha" do Usuário do usuário é obrigatório',
            'Senha.min' => 'O campo "Senha" do Usuário deve ter no minimo 3 caracteres',
            'Senha.max' => 'O campo "Senha" do Usuário deve ter até 20 caracteres',
            'ConfirmarSenha.required' => 'O campo "Confirmação" de Senha do Usuário é obrigatória',
            'ConfirmarSenha.in' => 'O campo "Confirmação" de Senha do Usuário deve ser igual à Senha',
            'Contratantes.required' => 'O campo "Contratante" do Usuário é obrigatório',
            'Contratantes.array' => 'O campo "Contratante" do Usuário é obrigatório',
        ];

        // VALIDAÇÕES DO AVATAR
        if (isset($parametros['Avatar'])) {
            $regras['Avatar'] = ['image', 'mimes:jpeg,png,jpg', 'max:2048'];
            $feedback['Avatar.image'] = 'O campo "Avatar" do Usuário deve ser uma imágem válida';
            $feedback['Avatar.mimes'] = 'O campo "Avatar" do Usuário deve ser uma imágem dentre os formátos (PNG, JPG, JPEG)';
            $feedback['Avatar.max'] = 'O campo "Avatar" do Usuário deve ter até 2mb';
        }

        // EXECUTA A VALIDAÇÃO
        $validator = Validator::make($parametros, $regras, $feedback);

        // EXECUTA AS VALIDAÇÕES ESPECIFICAS POSTERIORES
        $validator->after(function ($validator) use ($parametros) {
            // REGRA ADICIONAL DE VALIDAÇÃO DE ACESSO "UNICO"
            if (@$parametros['Acesso']) {
                $consulta_acesso = $this->consultar([
                    'Colunas' => [
                        'Base' => true
                    ],
                    'Filtros' => [
                        'Base' => [
                            'idContratante' => $parametros['idContratante'],
                            'Acesso' => $parametros['Acesso'],
                        ]
                    ],
                    'Ordenacao' => [
                        'Campo' => 'Nome',
                        'Ordem' => 'ASC',
                    ],
                    'Limite' => [],
                ]);

                if ($consulta_acesso['resposta'] == 'sucesso') {
                    $validator->errors()->add('Acesso', 'O campo "Acesso" do Usuário já está sendo usado em outro cadastro, por favor coloque outro');
                }
            }
        });

        // VALIDA SE TEM ERROS
        if (!$validator->fails()) {
            // FAZ O CADASTRO
            $cadastro_usuario = $model_pessoas->cadastrar_pessoas($parametros);

            // VALIDA O CADASTRO
            if ($cadastro_usuario['resposta'] == 'sucesso') {
                // RETORNOS DO CADASTRO
                $resposta = 'sucesso';
                $mensagem = array_merge($mensagem ?? [], $cadastro_usuario['mensagem'] ?? []);
                $dados['feedbacks']['sucesso'] = array_merge($dados['feedbacks']['sucesso'] ?? [], $cadastro_usuario['mensagem']);
                $dados['id'] = $cadastro_usuario['dados'];

                // INSERE O AVATAR SE EXISTIR
                if (isset($parametros['Avatar'])) {
                    // MOVE O ARQUIVO FISICAMENTE
                    if ($parametros['Avatar']->move(
                        public_path('img/avatar'),
                        str_pad($dados['id'], 6, '0', STR_PAD_LEFT) . '.png'
                    )) {
                        // EDITA O USUÁRIO QUE ACABOU DE SER CADASTRADO COM O AVATAR
                        $editar_usuario = $model_pessoas->editar_pessoas([
                            'CodigoSistema' => $dados['id'],
                            'Avatar' => str_pad($dados['id'], 6, '0', STR_PAD_LEFT) . '.png'
                        ]);

                        // SE EDITAR O AVATAR DO USUÁRIO INCREMENTA O FEEDBACK
                        if ($editar_usuario['resposta'] == 'sucesso') {
                            $dados['feedbacks']['sucesso'] = array_merge($dados['feedbacks']['sucesso'] ?? [], ['Avatar do usuário (' . $parametros['Nome'] . ') salvo com sucesso']);
                        }
                    }
                }

                // VINCULA OS CONTRATANTES
                foreach ($parametros['Contratantes'] ?? [] as $i => $CodigoSistemaCriptografado) {
                    // EFETUA A CONSULTA DO CONTRATANTE
                    $consulta_contratante = $services_contratantes->consultar([
                        'Colunas' => [
                            'Base' => true
                        ],
                        'Filtros' => [
                            'Base' => [
                                'CodigoSistema' => $this->securityHelper->decrypt($CodigoSistemaCriptografado),
                                'Status' => 'Ativo',
                            ]
                        ],
                        'Ordenacao' => [
                            'Campo' => 'Nome',
                            'Ordem' => 'ASC',
                        ],
                        'Limite' => [],
                    ]);

                    // VALIDA A CONSULTA
                    if ($consulta_contratante['resposta'] == 'sucesso') {
                        // SETA O CONTRATANTE
                        $contratante = $consulta_contratante['dados']->first();
                        // EFETUA O CADASTRO NA USUARIOS_CONTRATANTES, VINCULANDO-OS
                        $cadastro_usuario_contratante = $model_pessoas->cadastrar_pessoas_contratantes([
                            'idUsuario' => $dados['id'],
                            'NomeUsuario' => $parametros['Nome'],
                            'idContratante' => $this->securityHelper->decrypt($CodigoSistemaCriptografado),
                            'NomeContratante' => $contratante->NomeContratante,
                        ]);

                        // RETORNOS
                        $mensagem = array_merge($mensagem ?? [], $cadastro_usuario_contratante['mensagem'] ?? []);
                        $dados['feedbacks']['sucesso'] = array_merge($dados['feedbacks']['sucesso'] ?? [], $cadastro_usuario_contratante['mensagem'] ?? []);
                    } else {
                        // RETORNOS
                        $mensagem = array_merge($mensagem ?? [], ['Não foi possível efetuar o vinculo do usuário com o contratante "' . $this->securityHelper->decrypt($CodigoSistemaCriptografado) . '", verifique o cadastro do mesmo']);
                        $dados['feedbacks']['erro'] = array_merge($dados['feedbacks']['erro'] ?? [], ['Não foi possível efetuar o vinculo do usuário com o contratante "' . $this->securityHelper->decrypt($CodigoSistemaCriptografado) . '", verifique o cadastro do mesmo']);
                    }
                }
            } else {
                // RETORNOS
                $resposta = "erro";
                $mensagem = array_merge($mensagem ?? [], $cadastro_usuario['mensagem'] ?? []);
                $dados['feedbacks']['erro'] = array_merge($mensagem ?? [], $cadastro_usuario['mensagem'] ?? []);
            }
        } else {
            // RETORNOS
            $resposta = "erro";
            $mensagem = $validator->errors()->all();
            $dados['feedbacks']['erro'] = $validator->errors();
        }

        // RETORNO
        return ["resposta" => $resposta, "mensagem" => $mensagem, "dados" => $dados];
    }

    /**
     * editar - método que recebe os parametros e edita um usuário
     *
     * @param array $parametros
     * @return array ['resposta', 'mensagem', 'dados']
     */
    public function editar(array $parametros): array
    {
        // MODELS
        $model_pessoas = new PessoasModel;

        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        // REGRAS DE VALIDAÇÃO
        $regras = [
            'idContratante' => ['required'],
            'Nome' => ['required', 'max:255', 'min:3', 'regex:/^(?:[\p{L}\p{N}\s\-\/\(\)\.\çÇ]+)$/u', new FPI],
            'Email' => ['nullable', 'email', 'max:255', 'min:3', new FPI],
            'Acesso' => ['required', 'regex:/^[a-z0-9.]*$/', new FPI],
            'Status' => ['required'],
            'Contratantes' => ['required', 'array']
        ];

        // MENSAGENS DE RETORNO DE VALIDAÇÃO
        $feedback = [
            'idContratante.required' => 'O campo "Contratante" do Usuario é obrigatório',
            'Nome.required' => 'O campo "Nome" do Usuário é obrigatório',
            'Nome.min' => 'O campo "Nome" do Usuário deve ter pelo menos 3 caracteres',
            'Nome.max' => 'O campo "Nome" do Usuário deve ter até 255 caracteres',
            'Nome.regex' => 'O campo "Nome" do Usuário deve ter apenas "letras", "números", e os seguintes caracteres especiais "/ - . ( )"',
            'Email.email' => 'O campo "Email" do Usuário deve ser um E-mail válido',
            'Email.min' => 'O campo "Email" do Usuário deve ter pelo menos 3 caracteres',
            'Email.max' => 'O campo "Email" do Usuário deve ter até 255 caracteres',
            'Acesso.required' => 'O campo "Acesso" do Usuário é obrigatório',
            'Acesso.regex' => 'O campo "Acesso" do Usuário deve ter apenas "letras", "números" e "pontos"',
            'Status.required' => 'O campo "Status" do Usuário é obrigatório',
            'Contratantes.required' => 'O campo "Contratante" do Usuário é obrigatório',
            'Contratantes.array' => 'O campo "Contratante" do Usuário é obrigatório',
        ];

        // VALIDAÇÕES DO AVATAR
        if (isset($parametros['Avatar'])) {
            $regras['Avatar'] = ['image', 'mimes:jpeg,png,jpg', 'max:2048'];
            $feedback['Avatar.image'] = 'O campo "Avatar" do Usuário deve ser uma imágem válida';
            $feedback['Avatar.mimes'] = 'O campo "Avatar" do Usuário deve ser uma imágem dentre os formátos (PNG, JPG, JPEG)';
            $feedback['Avatar.max'] = 'O campo "Avatar" do Usuário deve ter até 2mb';
        }

        // EXECUTA A VALIDAÇÃO
        $validator = Validator::make($parametros, $regras, $feedback);

        // EXECUTA AS VALIDAÇÕES ESPECIFICAS POSTERIORES
        $validator->after(function ($validator) use ($parametros) {
            // REGRA ADICIONAL DE VALIDAÇÃO DE ACESSO "UNICO"
            if (@$parametros['Acesso']) {
                $consulta_acesso = $this->consultar([
                    'Colunas' => [
                        'Base' => true
                    ],
                    'Filtros' => [
                        'Base' => [
                            'idContratante' => $parametros['idContratante'],
                            'Acesso' => $parametros['Acesso'],
                        ]
                    ],
                    'Ordenacao' => [
                        'Campo' => 'Nome',
                        'Ordem' => 'ASC',
                    ],
                    'Limite' => [],
                ]);

                if ($consulta_acesso['resposta'] == 'sucesso' && ($consulta_acesso['dados']->first()->CodigoSistema != $parametros['CodigoSistema'])) {
                    $validator->errors()->add('Acesso', 'O campo "Acesso" do Usuário já está sendo usado em outro cadastro. <a href="' . route('cadastros.acessos.pessoas.detalhes', [$consulta_acesso['dados']->first()->CodigoSistemaCriptografado]) . '" class="text-primary font-weight-bold" target="_blank">Clique aqui</a> para acessar os detalhes do mesmo');
                }
            }
        });

        // VALIDA SE TEM ERROS
        if (!$validator->fails()) {
            // INSERE O AVATAR SE EXISTIR
            if (isset($parametros['Avatar'])) {
                // SE EDITAR O AVATAR MOVE O ARQUIVO FISICAMENTE
                $parametros['Avatar']->move(
                    public_path('img/avatar'),
                    str_pad($parametros['CodigoSistema'], 6, '0', STR_PAD_LEFT) . '.png'
                );

                // POSTERIORMENTE EDITA SOMENTE PARA O NOME DO ARQUIVO, PARA SALVAR NA TABELA USUÁRIOS
                $parametros['Avatar'] = str_pad($parametros['CodigoSistema'], 6, '0', STR_PAD_LEFT) . '.png';
            }

            // FAZ A EDIÇÃO NA TABELA USUÁRIOS
            $editar_usuario = $model_pessoas->editar_pessoas($parametros);
            // RETORNOS
            $mensagem = array_merge($mensagem ?? [], $editar_usuario['mensagem']);
            if ($editar_usuario['resposta'] == 'sucesso') {
                $dados['feedbacks']['sucesso'] = array_merge($dados['feedbacks']['sucesso'] ?? [], $editar_usuario['mensagem']);
            } else {
                $dados['feedbacks']['atencao'] = array_merge($dados['feedbacks']['atencao'] ?? [], $editar_usuario['mensagem']);
            }

            // REMOVE OS VINCULOS NA USUÁRIOS CONTRATANTES
            $remover_pessoas_contratantes = $model_pessoas->remover_pessoas_contratantes(['CodigoSistema' => $parametros['CodigoSistema']]);
            // RETORNOS
            $mensagem = array_merge($mensagem ?? [], $remover_pessoas_contratantes['mensagem']);
            if ($remover_pessoas_contratantes['resposta'] == 'sucesso') {
                $dados['feedbacks']['sucesso'] = array_merge($dados['feedbacks']['sucesso'] ?? [], $remover_pessoas_contratantes['mensagem']);
            }

            // RETORNO
            $resposta = 'sucesso';
        } else {
            // RETORNOS
            $resposta = "erro";
            $mensagem = $validator->errors()->all();
            $dados['feedbacks']['erro'] = $validator->errors();
        }

        // RETORNO
        return ["resposta" => $resposta, "mensagem" => $mensagem, "dados" => $dados];
    }

    /**
     * remover - método que recebe os parametros e remove logicamente um usuário
     *
     * @param array $parametros
     * @return array ['resposta', 'mensagem', 'dados']
     */
    public function remover(array $parametros): array
    {
        // MODELS
        $model_pessoas = new PessoasModel;

        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        // REGRAS DE VALIDAÇÃO
        $regras = [
            'CodigoSistema' => ['required'],
        ];

        // MENSAGENS DE RETORNO DE VALIDAÇÃO
        $feedback = [
            'CodigoSistema.required' => 'CodigoSistema não enviado na requisição, favor verificar',
        ];

        // VALIDAÇÃO
        $validator = Validator::make($parametros, $regras, $feedback);

        // VALIDA SE TEM ERROS
        if (!$validator->fails()) {
            // FAZ A BUSCA
            $remover = $model_pessoas->editar_pessoas([
                'CodigoSistema' => $this->securityHelper->decrypt($parametros['CodigoSistema']),
                'DataDelete' => date('Y-m-d H:i:s'),
            ]);

            // VALIDA A EDIÇÃO
            if ($remover['resposta'] == 'sucesso') {
                // RETORNOS
                $resposta = "sucesso";
                $mensagem[] = 'Usuário "' . $this->securityHelper->decrypt($parametros['CodigoSistema']) . '" removido com sucesso';
                $dados = null;
            } else {
                $resposta = "atencao";
                $mensagem[] = "Nenhuma alteração foi feita";
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
