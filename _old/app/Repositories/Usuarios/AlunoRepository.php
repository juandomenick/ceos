<?php

namespace App\Repositories\Usuarios;

use App\Models\Usuarios\Aluno;
use App\Repositories\Usuarios\Interfaces\AlunoRepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AlunoRepository implements AlunoRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return is_null($paginate) ? Aluno::all() : Aluno::paginate($paginate);
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
            Aluno::where($where)->orWhere($orWhere)->get() :
            Aluno::where($where)->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return Aluno::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorUser(User $user): object
    {
        return $user->aluno()->first();
    }
}