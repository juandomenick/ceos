<?php

namespace App\Criteria\Academico\Turmas;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AtividadeTurmaCriteria.
 *
 * @package namespace App\Criteria\Academico\Turmas;
 */
class AtividadeTurmaCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (Auth::user()->hasRole('professor') && !Auth::user()->hasRole('administrador')) {
            $model = $model->where('professor_id', Auth::user()->professor->id);
        }

        return $model;
    }
}
