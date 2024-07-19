<?php

namespace App\Repositories\Geral;

use App\Models\Geral\Cidade;
use App\Repositories\Geral\Interfaces\CidadeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CidadeRepository
 *
 * @package App\Repositories\Localizacao
 */
class CidadeRepository implements CidadeRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function buscarPorEstado(int $estadoId): Collection
    {
        return Cidade::where('estado_id', $estadoId)->get();
    }
}