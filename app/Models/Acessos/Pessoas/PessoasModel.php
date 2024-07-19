<?php

namespace App\Models\Acessos\Pessoas;

use App\Models\Model;

class PessoasModel extends Model
{
    // CONSTRUCT
    public function __construct()
    {
        // PARENTS DA INSTANCIA
        parent::__construct();

        // CONEXÃO COM O BANCO
        $this->connection = $this->set('mysql');
    }

    public function consultar_pessoas(?array $colunas, ?array $filtros, ?array $ordenacao, ?array $limite): array
    {
        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        try {
            // PARAMETROS
            $parametros = [];

            // QUERY
            $selects = [];
            $joins = [];
            $datadeletes = [];
            $where = [];
            $order = [];
            $limit = [];

            // COLUNAS
            $index_colunas = 0;
            if (@$colunas) {
                if (!in_array("pes.DataDelete IS NULL", $datadeletes)) array_push($datadeletes, "pes.DataDelete IS NULL");
                // PERCORRE AS COLUNAS E CONSTROI A VARIAVEL SELECTS E A JOINS
                foreach ($colunas ?? [] as $elemento => $coluna) {
                    switch (mb_strtoupper($elemento)) {
                        case mb_strtoupper('Base'):
                            // COLUNAS
                            if ($coluna === true || isset($coluna['CodigoSistema'])) $selects[$coluna['CodigoSistema'] ?? $index_colunas++] = 'pes.idPessoa AS CodigoSistema';
                            if ($coluna === true || isset($coluna['Cpf'])) $selects[$coluna['Cpf'] ?? $index_colunas++] = 'pes.Cpf AS CpfPessoa';
                            if ($coluna === true || isset($coluna['Rg'])) $selects[$coluna['Rg'] ?? $index_colunas++] = 'pes.Rg AS RgPessoa';
                            if ($coluna === true || isset($coluna['Passaporte'])) $selects[$coluna['Passaporte'] ?? $index_colunas++] = 'pes.Passaporte AS PassaportePessoa';
                            if ($coluna === true || isset($coluna['Acesso'])) $selects[$coluna['Acesso'] ?? $index_colunas++] = 'pes.Acesso AS AcessoPessoa';
                            if ($coluna === true || isset($coluna['Nome'])) $selects[$coluna['Nome'] ?? $index_colunas++] = 'pes.Nome AS NomePessoa';
                            if ($coluna === true || isset($coluna['NomeSocial'])) $selects[$coluna['NomeSocial'] ?? $index_colunas++] = 'pes.NomeSocial AS NomeSocialPessoa';
                            if ($coluna === true || isset($coluna['Email'])) $selects[$coluna['Email'] ?? $index_colunas++] = 'pes.Email AS EmailPessoa';
                            if ($coluna === true || isset($coluna['Lattes'])) $selects[$coluna['Lattes'] ?? $index_colunas++] = 'pes.Lattes AS LattesPessoa';
                            if ($coluna === true || isset($coluna['Senha'])) $selects[$coluna['Senha'] ?? $index_colunas++] = 'pes.Senha AS SenhaPessoa';
                            if ($coluna === true || isset($coluna['Status'])) $selects[$coluna['Status'] ?? $index_colunas++] = 'pes.Status AS StatusPessoa';
                            if ($coluna === true || isset($coluna['DataNascimento'])) $selects[$coluna['DataNascimento'] ?? $index_colunas++] = 'DATE_FORMAT(pes.DataNascimento, "%d/%m/%Y %H:%i:%s") AS DataNascimentoPessoa';
                            if ($coluna === true || isset($coluna['DataInsert'])) $selects[$coluna['DataInsert'] ?? $index_colunas++] = 'DATE_FORMAT(pes.DataInsert, "%d/%m/%Y %H:%i:%s") AS DataCadastroPessoa';
                            break;

                        case mb_strtoupper('Nivel'):
                            // JOIN
                            if (!in_array("INNER JOIN pessoas_niveis_nomenclaturas pnn ON pnn.idPessoaNivelNomenclatura = pes.idPessoaNivelNomenclatura", $joins)) array_push($joins, "INNER JOIN pessoas_niveis_nomenclaturas pnn ON pnn.idPessoaNivelNomenclatura = pes.idPessoaNivelNomenclatura");
                            // DATA DELETE
                            if (!in_array("pnn.DataDelete IS NULL", $datadeletes)) array_push($datadeletes, "pnn.DataDelete IS NULL");
                            // COLUNA
                            if ($coluna === true || isset($coluna['CodigoSistema'])) $selects[$coluna['CodigoSistema'] ?? $index_colunas++] = 'pnn.idPessoaNivelNomenclatura AS Nivel';
                            if ($coluna === true || isset($coluna['Nome'])) $selects[$coluna['Nome'] ?? $index_colunas++] = 'pnn.Nivel AS Nivel';
                            break;
                    }
                }
            }

            // FILTROS
            if (@$filtros) {
                // PERCORRE OS FILTROS E CONSTROI A VARIAVEL WHERES
                foreach ($filtros ?? [] as $elemento => $campos) {
                    switch (mb_strtoupper($elemento)) {
                        case mb_strtoupper('Base'):
                            foreach ($campos ?? [] as $filtro => $dado) {
                                switch (mb_strtoupper($filtro)) {
                                    case mb_strtoupper('CodigoSistema'):
                                        if (isset($dado)) {
                                            array_push($where, "pes.idPessoa IN (?)");
                                            array_push($parametros, implode(", ", is_array($dado) ? $dado : [$dado]));
                                        }
                                        break;

                                    case mb_strtoupper('CodigoSistemaCriptografado'):
                                        if (isset($dado)) {
                                            array_push($where, "pes.idPessoa = ?");
                                            array_push($parametros, $this->securityHelper->decrypt($dado));
                                        }
                                        break;

                                    case mb_strtoupper('Nome'):
                                        if (isset($dado)) {
                                            array_push($where, "pes.Nome LIKE (?)");
                                            array_push($parametros, "%" . $dado . "%");
                                        }
                                        break;

                                    case mb_strtoupper('Acesso'):
                                        if (isset($dado)) {
                                            array_push($where, "pes.Acesso = ?");
                                            array_push($parametros, $dado);
                                        }
                                        break;

                                    case mb_strtoupper('Email'):
                                        if (isset($dado)) {
                                            array_push($where, "pes.Email LIKE (?)");
                                            array_push($parametros, "%" . $dado . "%");
                                        }
                                        break;

                                    case mb_strtoupper('Status'):
                                        if (isset($dado)) {
                                            array_push($where, "pes.Status = ?");
                                            array_push($parametros, $dado);
                                        }
                                        break;
                                }
                            }
                            break;

                        case mb_strtoupper('Nivel'):
                            // JOIN
                            if (!in_array("INNER JOIN pessoas_niveis_nomenclaturas pnn ON pnn.idPessoaNivelNomenclatura = pes.idPessoaNivelNomenclatura", $joins)) array_push($joins, "INNER JOIN pessoas_niveis_nomenclaturas pnn ON pnn.idPessoaNivelNomenclatura = pes.idPessoaNivelNomenclatura");
                            // DATA DELETE
                            if (!in_array("pnn.DataDelete IS NULL", $datadeletes)) array_push($datadeletes, "pnn.DataDelete IS NULL");
                            // FILTROS
                            foreach ($campos ?? [] as $filtro => $dado) {
                                switch (mb_strtoupper($filtro)) {
                                    case mb_strtoupper('Nivel'):
                                        if (isset($dado)) {
                                            array_push($where, "pnn.Nivel = ?");
                                            array_push($parametros, implode(", ", is_array($dado) ? $dado : [$dado]));
                                        }
                                        break;
                                }
                            }
                            break;
                    }
                }
            }

            // ORDER
            if (@$ordenacao) {
                // INICIA A ORDENAÇÃO
                array_push($order, "ORDER BY");
                // CAMPO DA ORDENAÇÃO
                switch (mb_strtoupper(@$ordenacao['Campo'])) {
                    case mb_strtoupper('CodigoSistema'):
                        array_push($order, "pes.idPessoa");
                        break;

                    case mb_strtoupper('Nome'):
                        array_push($order, "pes.Nome");
                        break;

                    case mb_strtoupper('Status'):
                        array_push($order, "pes.Status");
                        break;

                    case mb_strtoupper('DataInsert'):
                        array_push($order, "pes.DataInsert");
                        break;

                    default:
                        array_push($order, "pes.idPessoa");
                        break;
                }
                // ORDEM DA ORDENAÇÃO
                switch (mb_strtoupper(@$ordenacao['Ordem'])) {
                    case mb_strtoupper('DESC'):
                        array_push($order, "DESC");
                        break;

                    case mb_strtoupper('ASC'):
                        array_push($order, "ASC");
                        break;

                    default:
                        array_push($order, "");
                        break;
                }
            }

            // TRATATIVA DOS VETORES
            ksort($selects);
            $selects = count($selects) ? implode(',', $selects) : '';
            $joins = count($joins) ? implode(' ', $joins) : '';
            $datadeletes = count($datadeletes) ? implode(' AND ', $datadeletes) : '';
            $where = count($where) ? 'AND ' . implode(' AND ', $where) : '';
            $order = count($order) ? implode(' ', $order) : '';
            $limit = isset($limite['Limit']) ? "Limit {$limite['Limit']}" : '';

            // VALIDA OS DADOS CONSTRUIDOS
            if ($selects) {
                // SELECT
                $sql = "SELECT {$selects} FROM pessoas pes {$joins} WHERE {$datadeletes} {$where} {$order} {$limit};";
                // EFETUA A CONSULTA
                $consulta = collect($this->connection->select($sql, $parametros));
                // VALIDA SE A CONSULTA VEIO VAZIA
                if (!$consulta->isEmpty()) {
                    $resposta = 'sucesso';
                    $mensagem[] = 'Consulta efetuada, "' . count($consulta) . '" pessoa(s) encontrado(s) com sucesso';
                    $dados = $consulta;
                } else {
                    $resposta = 'atencao';
                    $mensagem[] = 'Não foi possível consultar pessoa(s) com o(s) parametro(s) enviado(s)';
                    $dados = null;
                }
            } else {
                $resposta = 'erro';
                $mensagem[] = 'Parametros inválidos para efetuar a consulta de pessoa(s)';
                $dados = null;
            }
        } catch (\Exception $e) {
            // RESGATA OS ERROS
            if ($e instanceof \PDOException) {
                $resposta = 'erro';
                $mensagem[] = 'Houve um erro ao consultar pessoas <i class="fa-light fa-circle-question ml-1" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="' . $e->getMessage() . '"></i>';
                $dados = null;
            } else {
                $resposta = 'erro';
                $mensagem[] = 'Houve um erro ao consultar pessoas <i class="fa-light fa-circle-question ml-1" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="' . $e->getMessage() . '"></i>';
                $dados = null;
            }
        }

        // RETORNO
        return ['resposta' => $resposta, 'mensagem' => $mensagem, 'dados' => $dados];
    }

    public function cadastrar_pessoas(?array $campos): array
    {
        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        try {
            // INSERT
            $sql = "INSERT INTO pessoas (idPessoaNivelNomenclatura, Cpf, Rg, Passaporte, Acesso, Nome, NomeSocial, Email, Lattes, Senha, DataNascimento, Status, DataInsert)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW());
            ";

            // PARAMETROS
            $parametros = [
                $campos['idPessoaNivelNomenclatura'] ?? null,
                $campos['Cpf'] ?? null,
                $campos['Rg'] ?? null,
                $campos['Passaporte'] ?? null,
                $campos['Acesso'] ?? null,
                $campos['Nome'] ?? null,
                $campos['NomeSocial'] ?? null,
                $campos['Email'] ?? null,
                $campos['Lattes'] ?? null,
                $campos['Senha'] ? password_hash($campos['Senha'], PASSWORD_DEFAULT) : null,
                $campos['DataNascimento'] ?? null,
                $campos['Status'] ?? null,
            ];

            // CADASTRO
            if ($this->connection->insert($sql, $parametros)) {
                // PEGA O ID
                $idPessoa = $this->connection->getPdo()->lastInsertId();

                // RETORNO
                $resposta = 'sucesso';
                $mensagem[] = 'Usuário "' . $campos['Nome'] . '" cadastrado com sucesso. <a href="' . route('cadastros.acessos.pessoas.detalhes', [$this->securityHelper->encrypt($idPessoa)]) . '" class="text-primary font-weight-bold" target="_blank">Clique aqui</a> para acessar os detalhes do mesmo.';
                $dados = $idPessoa;
            } else {
                $resposta = 'erro';
                $mensagem[] = 'Houve um erro ao cadastrar o pessoa <i class="fa-light fa-circle-question ml-1" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Não foi possível cadastrar (pessoas)"></i>';
                $dados = null;
            }
        } catch (\Exception $e) {
            // RESGATA OS ERROS
            if ($e instanceof \PDOException) {
                $resposta = 'erro';
                $mensagem[] = 'Houve um erro ao cadastrar o pessoa <i class="fa-light fa-circle-question ml-1" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="' . $e->getMessage() . '"></i>';
                $dados = null;
            } else {
                $resposta = 'erro';
                $mensagem[] = 'Houve um erro ao cadastrar o pessoa <i class="fa-light fa-circle-question ml-1" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="' . $e->getMessage() . '"></i>';
                $dados = null;
            }
        }

        // RETORNO
        return ['resposta' => $resposta, 'mensagem' => $mensagem, 'dados' => $dados];
    }

    public function editar_pessoas(?array $campos): array
    {
        // VARIAVEIS DE RETORNO
        $resposta = null;
        $mensagem = null;
        $dados = null;

        try {
            // PARAMETROS A SEREM APLICADOS
            $parametros = [];

            // CAMPOS QUE SERÃO EDITADOS
            $colunas = [];

            // NOME
            if (array_key_exists('Nome', $campos)) {
                $colunas[] = 'Nome = ?';
                $parametros[] = $campos['Nome'];
            }

            // USUARIO
            if (array_key_exists('Acesso', $campos)) {
                $colunas[] = 'Acesso = ?';
                $parametros[] = $campos['Acesso'];
            }

            // EMAIL
            if (array_key_exists('Email', $campos)) {
                $colunas[] = 'Email = ?';
                $parametros[] = $campos['Email'];
            }

            // STATUS
            if (array_key_exists('Status', $campos)) {
                $colunas[] = 'Status = ?';
                $parametros[] = $campos['Status'];
            }

            // AVATAR
            if (array_key_exists('Avatar', $campos)) {
                $colunas[] = 'Avatar = ?';
                $parametros[] = $campos['Avatar'];
            }

            // DATADELETE
            if (array_key_exists('DataDelete', $campos)) {
                $colunas[] = 'DataDelete = ?';
                $parametros[] = $campos['DataDelete'];
            }

            $colunas = count($colunas) ? implode(',', $colunas) : '';
            if ($colunas) {
                // UPDATE
                $sql = "UPDATE pessoas SET {$colunas} WHERE idPessoa = ?;";
                // PARAMETRO PRINCIPAL
                $parametros[] = $campos['CodigoSistema'];

                // EFETUA O UPDATE
                if ($update = $this->connection->update($sql, $parametros)) {
                    // RETORNO
                    $resposta = 'sucesso';
                    $mensagem[] = 'Usuário "' . ($campos['Nome'] ?? $campos['CodigoSistema']) . '" atualizado com sucesso';
                    $dados = $update;
                } else {
                    // RETORNO
                    $resposta = 'atencao';
                    $mensagem[] = 'Nenhuma informação de "Dados" do pessoa foi alterada';
                    $dados = null;
                }
            } else {
                // RETORNO
                $resposta = 'erro';
                $mensagem[] = 'Parametros inválidos para atualizar o pessoa';
                $dados = null;
            }
        } catch (\Exception $e) {
            // RESGATA OS ERROS
            if ($e instanceof \PDOException) {
                $resposta = 'erro';
                $mensagem[] = 'Houve um erro ao atualizar "Dados" do pessoa <i class="fa-light fa-circle-question ml-1" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="' . $e->getMessage() . '"></i>';
                $dados = null;
            } else {
                $resposta = 'erro';
                $mensagem[] = 'Houve um erro ao atualizar "Dados" do pessoa <i class="fa-light fa-circle-question ml-1" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="' . $e->getMessage() . '"></i>';
                $dados = null;
            }
        }

        // RETORNO
        return ['resposta' => $resposta, 'mensagem' => $mensagem, 'dados' => $dados];
    }
}
