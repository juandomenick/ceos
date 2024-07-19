<?php

namespace App\Repositories\Geral\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class EstadoRepositoryInterface
 *
 * @package App\Repositories\Localizacao\Interfaces
 */
interface EstadoRepositoryInterface
{
    /**
     * Lista todos os Estados
     *
     * @return Collection
     */
    public function listarTodos(): Collection;
}