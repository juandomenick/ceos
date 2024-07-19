<?php

namespace App\Criteria\Academico\Questoes;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class QuestaoCriteria.
 *
 * @package namespace App\Criteria\Academico;
 */
class QuestaoCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (Auth::user()->hasRole('professor')) {
            $model = $model->where('professor_id', Auth::user()->professor->id);
        }

        return $model;
    }
}
