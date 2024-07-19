<?php

namespace App\Services\Geral\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface EstadoServiceInterface
 *
 * @package App\Services\Localizacao\Interfaces
 */
interface EstadoServiceInterface
{
    /**
     * Lista todos os Estados.
     *
     * @return Collection
     */
    public function listarTodos(): Collection;
}