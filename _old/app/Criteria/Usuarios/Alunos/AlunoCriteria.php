<?php

namespace App\Criteria\Usuarios\Alunos;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AlunoCriteria.
 *
 * @package namespace App\Criteria\Usuarios\Alunos;
 */
class AlunoCriteria implements CriteriaInterface
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
            $model = $model->whereHas('equipes.turma.disciplina.curso.instituicao', function ($query) {
                return $query->where('diretor_id', Auth::id());
            });
        }

        if (Auth::user()->hasRole('professor') && !Auth::user()->hasRole('administrador|coordenador|diretor')) {
            $model = $model->whereHas('equipes.turma', function ($query) {
                return $query->where('professor_id', Auth::user()->professor->id);
            });
        }

        if (Auth::user()->hasRole('coordenador') && !Auth::user()->hasRole('administrador')) {
            $model = $model->whereHas('equipes.turma.disciplina.curso', function ($query) {
                return $query->where('coordenador_id', Auth::user()->coordenador->id);
            });
        }

        return $model;
    }
}
