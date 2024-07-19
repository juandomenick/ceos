<?php

namespace App\Repositories\Academico;

use App\Models\Academico\Curso;
use App\Repositories\Academico\Interfaces\CursoRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

/**
 * Class CursoRepository
 *
 * @package App\Repositories\Academico
 */
class CursoRepository implements CursoRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        $query = Curso::query();

        $this->buscarPorInstituicao($query);

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        $query = Curso::query();

        $this->buscarPorInstituicao($query);

        if (isset($parametros['nome']))
            $query->where('nome', $parametros['nome']);

        if (isset($parametros['sigla']))
            $query->where('sigla', $parametros['sigla']);

        if (isset($parametros['nivel']))
            $query->where('nivel', $parametros['nivel']);

        if (isset($parametros['ativo']))
            $query->where('ativo', $parametros['ativo']);

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        $query = Curso::query();

        $this->buscarPorInstituicao($query);

        $where && $orWhere ? $query->where($where)->orWhere($orWhere) : $query->where($where);

        return $query->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        $query = Curso::query();

        $this->buscarPorInstituicao($query);

        $query->where('id', $id);

        if (is_null($query->first()))
            throw new ModelNotFoundException('Curso não encontrado.');

        return $query->first();
    }

    /**
     * Busca apenas Cursos pertencentes às Instituições do Diretor autenticado.
     *
     * @param Builder $query
     * @return void
     */
    private function buscarPorInstituicao(Builder $query): void
    {
        $user = Auth::user();

        if ($user->hasRole('diretor') && !$user->hasRole('administrador')) {
            $query->whereHas('instituicao', function ($query) use ($user) {
                $query->where('diretor_id', $user->id);
            });
        }

        if ($user->hasRole('coordenador') && !$user->hasRole('administrador|professor')) {
            $query->where('coordenador_id', $user->coordenador->id);
        }

        if ($user->hasRole('professor') && !$user->hasRole('administrador')) {
            $query->orWhereHas('professores', function ($query) use ($user) {
                $query->where('professor_id', $user->professor->id);
            });
        }
    }
}