<?php

namespace App\Criteria\Academico\AnotacoesAula;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AnotacaoAulaCriteria.
 *
 * @package namespace App\Criteria\Academico;
 */
class AnotacaoAulaCriteria implements CriteriaInterface
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
        if (Auth::user()->hasRole('diretor') && !Auth::user()->hasRole('administrador')) {
            $model = $model->whereHas('turma.disciplina.curso.instituicao', function ($query) {
                return $query->where('diretor_id', Auth::id());
            });
        }

        if (Auth::user()->hasRole('coordenador') && !Auth::user()->hasRole('administrador')) {
            $model = $model->whereHas('turma.disciplina.curso', function ($query) {
                return $query->where('coordenador_id', Auth::user()->coordenador->id);
            });
        }

        if (Auth::user()->hasRole('professor') && !Auth::user()->hasRole('administrador')) {
            $model = $model->orWhere('professor_id', Auth::user()->professor->id);
        }

        return $model;
    }
}
