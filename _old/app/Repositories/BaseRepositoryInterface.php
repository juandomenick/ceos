<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * Lista todos os recursos, aplicando paginação se $paginate for informado.
     *
     * @param int|null $paginate
     * @return object
     */
    public function listarTodos(int $paginate = null): object;

    /**
     * Aplica os filtros passados no array $params, retornando os dados paginados se o parâmetro $paginate for informado.
     *
     * @param array $parametros
     * @param int|null $paginate
     * @return object
     */
    public function filtrar(array $parametros, int $paginate = null): object;

    /**
     * Busca Recursos a partir dos parâmetros passados nos arrays $where e $orWhare
     *
     * @param array $where
     * @param array $orWhere
     * @return object
     */
    public function buscar(array $where, array $orWhere = []): object;

    /**
     * Busca um Recurso por ID.
     *
     * @param int $id
     * @return Model
     */
    public function buscarPorId(int $id): Model;
}