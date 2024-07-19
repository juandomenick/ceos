<?php

namespace App\Repositories\Usuarios;

use App\Models\Usuarios\ResponsavelAluno;
use App\Repositories\Usuarios\Interfaces\ResponsavelAlunoRepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ResponsavelAlunoRepository implements ResponsavelAlunoRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return is_null($paginate) ? ResponsavelAluno::all() : ResponsavelAluno::paginate($paginate);
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
            ResponsavelAluno::where($where)->orWhere($orWhere)->get() :
            ResponsavelAluno::where($where)->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return ResponsavelAluno::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorUser(User $user): object
    {
        return $user->responsavelAluno()->first();
    }
}