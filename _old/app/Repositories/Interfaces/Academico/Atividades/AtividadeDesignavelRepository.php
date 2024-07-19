<?php

namespace App\Repositories\Interfaces\Academico\Atividades;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AtividadeDesignavelRepository.
 *
 * @package namespace App\Repositories\Interfaces\Academico;
 */
interface AtividadeDesignavelRepository extends RepositoryInterface
{
    /**
     * Registra respostas da Atividade.
     *
     * @param array $attributes
     * @return LengthAwarePaginator|Collection|mixed
     */
    public function responder(array $attributes);
}
