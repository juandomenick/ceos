<?php

namespace App\Repositories\Usuarios;

use App\Repositories\Usuarios\Interfaces\DiretorRepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DiretorRepository implements DiretorRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        $diretores = User::role('diretor');
        return is_null($paginate) ? $diretores->get() : $diretores->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        $query = User::query();

        $query->role('diretor');

        if (isset($parametros['nome']))
            $query->where('nome', 'LIKE', "%{$parametros['nome']}%");

        return is_null($paginate) ? $query->get() : $query->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        return $where && $orWhere ?
            User::role('diretor')->where($where)->orWhere($orWhere)->get() :
            User::role('diretor')->where($where)->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return User::role('diretor')->where('id', $id)->first();
    }
}