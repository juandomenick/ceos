<?php

namespace App\Services\Geral\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CidadeServiceInterface
 *
 * @package App\Services\Localizacao\Interfaces
 */
interface CidadeServiceInterface
{
    /**
     * Lista Cidades de um Estado específico a partir do parâmetro $estadoId.
     *
     * @param int $estadoId
     * @return Collection
     */
    public function buscarPorEstado(int $estadoId): Collection;
}