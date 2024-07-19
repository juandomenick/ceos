<?php

namespace App\Repositories\Usuarios;

use App\Models\Usuarios\Coordenador;
use App\Repositories\Usuarios\Interfaces\CoordenadorRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

/**
 * Class CoordenadorRepository
 *
 * @package App\Repositories\Usuarios
 */
class CoordenadorRepository implements CoordenadorRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        $query = Coordenador::query();

        $this->buscarPorInstituicaoDoDiretor($query);

        $query->with('user.roles');

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        $query = Coordenador::query();

        $this->buscarPorInstituicaoDoDiretor($query);

        if (isset($parametros['nome']))
            $query->whereHas('user', function ($query) use ($parametros) {
                $query->where('nome', 'LIKE', "%{$parametros['nome']}%");
            });

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        $query = Coordenador::query();

        $this->buscarPorInstituicaoDoDiretor($query);

        $where && $orWhere ? $query->where($where)->orWhere($orWhere) : $query->where($where);

        return $query->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        $query = Coordenador::query();

        $this->buscarPorInstituicaoDoDiretor($query);

        $query->where('id', $id);

        if (is_null($query->first()))
            throw new ModelNotFoundException('Coordenador não encontrado!');

        return $query->first();
    }

    /**
     * Busca apenas Coordenadores pertencentes às Instituições do Diretor autenticado.
     *
     * @param Builder $query
     * @return void
     */
    private function buscarPorInstituicaoDoDiretor(Builder $query): void
    {
        if (Auth::user()->hasRole('diretor') && !Auth::user()->hasRole('administrador')) {
            $query->whereHas('instituicao', function ($query) {
                $query->where('diretor_id', Auth::id());
            });
        }
    }
}