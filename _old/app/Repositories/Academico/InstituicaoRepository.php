<?php

namespace App\Repositories\Academico;

use App\Models\Academico\Instituicao;
use App\Repositories\Academico\Interfaces\InstituicaoRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

/**
 * Class InstituicaoRepository
 *
 * @package App\Repositories\Academico
 */
class InstituicaoRepository implements InstituicaoRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        $query = Instituicao::query();

        $this->buscarPorInstituicao($query);

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        $query = Instituicao::query();

        $this->buscarPorInstituicao($query);

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
        $query = Instituicao::query();

        $this->buscarPorInstituicao($query);

        $where && $orWhere ? $query->where($where)->orWhere($orWhere) : $query->where($where);

        return $query->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        $query = Instituicao::query();

        $this->buscarPorInstituicao($query);

        $query->where('id', $id);

        if (is_null($query->first()))
            throw new ModelNotFoundException('Instituição não encontrada.');

        return $query->first();
    }

    /**
     * Busca apenas Instituições pertencentes ao Diretor autenticado.
     *
     * @param Builder $query
     * @return void
     */
    private function buscarPorInstituicao(Builder $query): void
    {
        $user = Auth::user();

        if ($user->hasRole('administrador')) {
            $query->with('cursos');
        }

        if ($user->hasRole('diretor') && !$user->hasRole('administrador')) {
            $query->where('diretor_id', $user->id);
            $query->with('cursos');
        }

        if ($user->hasRole('coordenador') && !$user->hasRole('administrador')) {
            $query->whereHas('coordenadores', function($query) use ($user) {
                $query->where('user_id', $user->id);
            });

            $query->with(['cursos' => function ($query) use ($user) {
                $query->where('coordenador_id', $user->coordenador->id);
            }]);
        }

        if ($user->hasRole('professor') && !$user->hasRole('administrador')) {
            $query->orWhereHas('cursos.professores', function ($query) use ($user) {
                $query->where('professor_id', $user->professor->id);
            });

            $query->with(['cursos' => function ($query) use ($user) {
                $query->whereHas('professores', function ($query) use ($user) {
                    $query->where('professor_id', $user->professor->id);
                });
            }]);
        }
    }
}