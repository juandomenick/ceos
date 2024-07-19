<?php

namespace App\Repositories\Geral;

use App\Models\Geral\Estado;
use App\Repositories\Geral\Interfaces\EstadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EstadoRepository implements EstadoRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(): Collection
    {
        return Estado::all();
    }
}