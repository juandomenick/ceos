<?php

namespace App\Repositories\Academico;

use App\Models\Academico\Disciplina;
use App\Repositories\Academico\Interfaces\DisciplinaRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

/**
 * Class DisciplinaRepository
 *
 * @package App\Repositories\Academico
 */
class DisciplinaRepository implements DisciplinaRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        $query = Disciplina::query();

        $this->buscarPorInstituicao($query);
        $this->buscarPorCurso($query);

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        $query = Disciplina::query();

        $this->buscarPorInstituicao($query);
        $this->buscarPorCurso($query);

        if (isset($parametros['nome']))
            $query->where('nome', 'LIKE', "%{$parametros['nome']}%");

        if (isset($parametros['sigla']))
            $query->where('sigla', 'LIKE', "%{$parametros['sigla']}%");

        if (isset($parametros['ativo']))
            $query->where('ativo', 'LIKE', $parametros['ativo']);

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        $query = Disciplina::query();

        $this->buscarPorInstituicao($query);
        $this->buscarPorCurso($query);

        $where && $orWhere ? $query->where($where)->orWhere($orWhere) : $query->where($where);

        return $query->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        $query = Disciplina::query();

        $this->buscarPorInstituicao($query);
        $this->buscarPorCurso($query);

        $query->where('id', $id);

        if (is_null($query->first()))
            throw new ModelNotFoundException('Disciplina não encontrada.');

        return $query->first();
    }

    /**
     * Busca apenas Disciplinas pertencentes às Instituições do Diretor ou Coordenador autenticado.
     *
     * @param Builder $query
     * @return void
     */
    private function buscarPorInstituicao(Builder $query): void
    {
        if (Auth::user()->hasRole('diretor') && !Auth::user()->hasRole('administrador')) {
            $query->whereHas('curso.instituicao', function ($query) {
                $query->where('diretor_id', Auth::id());
            });
        }

        if (Auth::user()->hasRole('coordenador') && !Auth::user()->hasRole('administrador')) {
            $query->whereHas('curso.coordenador', function ($query) {
                $query->where('coordenador_id', Auth::user()->coordenador->id);
            });
        }

        $query->with('turmas');
    }

    /**
     * Busca apenas Disciplinas pertencentes aos Cursos do Professor autenticado.
     *
     * @param Builder $query
     * @return void
     */
    private function buscarPorCurso(Builder $query): void
    {
        if (Auth::user()->hasRole('professor') && !Auth::user()->hasRole('administrador')) {
            $query->orWhereHas('curso.professores', function ($query) {
                $query->where('professor_id', Auth::user()->professor->id);
            });

            $query->where('ativo', true);
            $query->with('turmas');
        }
    }
}