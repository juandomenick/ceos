<?php

namespace App\Repositories\Usuarios;

use App\Models\Usuarios\Professor;
use App\Repositories\Usuarios\Interfaces\ProfessorRepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ProfessorRepository implements ProfessorRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return is_null($paginate) ? Professor::all() : Professor::paginate($paginate);
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
            Professor::where($where)->orWhere($orWhere)->get() :
            Professor::where($where)->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return Professor::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorUser(User $user): object
    {
        return $user->professor()->first();
    }
}