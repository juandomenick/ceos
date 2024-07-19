<?php

namespace App\Repositories\Usuarios;

use App\Repositories\Usuarios\Interfaces\UsuarioRepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return is_null($paginate) ? User::all() : User::paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        // TODO: Implement filter() method.
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        return $where && $orWhere ?
            User::where($where)->orWhere($orWhere)->get() :
            User::where($where)->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return User::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorRoles(array $roles): Collection
    {
        return User::role($roles)->get();
    }
}