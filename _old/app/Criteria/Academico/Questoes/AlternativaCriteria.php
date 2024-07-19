<?php

namespace App\Criteria\Academico\Questoes;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AlternativaCriteria.
 *
 * @package namespace App\Criteria\Academico\Questoes;
 */
class AlternativaCriteria implements CriteriaInterface
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
            $model = $model->whereHas('questao', function ($query) {
                $query->where('professor_id', Auth::user()->professor->id);
            });
        }

        return $model;
    }
}
