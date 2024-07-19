<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseServiceInterface
 *
 * @package App\Services\Usuarios\Interfaces
 */
interface BaseServiceInterface
{
    /**
     * Lista todos os Recursos.
     *
     * @param int|null $paginate
     * @return object
     */
    public function listarTodos(int $paginate = null): object;

    /**
     * Filtra Recursos a partir dos parâmetros passados no array $parametros, retornando os dados paginados
     * se o parâmetro $paginate for informado.
     *
     * @param array $parametros
     * @param int|null $paginate
     * @return object
     */
    public function filtrar(array $parametros, int $paginate = null): object;

    /**
     * Busca Recurso por ID.
     *
     * @param int $id
     * @return Model
     */
    public function buscarPorId(int $id): Model;

    /**
     * Cadastra novo Recurso.
     *
     * @param object $dados
     * @return Model
     */
    public function cadastrar(object $dados): Model;

    /**
     * Atualiza Recurso.
     *
     * @param object $dados
     * @param int $id
     * @return Model
     */
    public function atualizar(object $dados, int $id): Model;

    /**
     * Deleta Recurso.
     *
     * @param int $id
     */
    public function deletar(int $id): void;
}