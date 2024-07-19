<?php

namespace App\Repositories\Geral\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CidadeRepositoryInterface
 *
 * @package App\Repositories\Localizacao\Interfaces
 */
interface CidadeRepositoryInterface
{
    /**
     * Lista Cidades de um Estado específico a partir do parâmetro $estadoId.
     *
     * @param int $estadoId
     * @return Collection
     */
    public function buscarPorEstado(int $estadoId): Collection;
}