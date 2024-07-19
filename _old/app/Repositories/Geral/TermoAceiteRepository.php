<?php

namespace App\Repositories\Geral;

use App\Models\Geral\TermoAceite;
use App\Repositories\Geral\Interfaces\TermoAceiteRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TermoAceiteRepository
 *
 * @package App\Repositories\Cadastros
 */
class TermoAceiteRepository implements TermoAceiteRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return is_null($paginate) ? TermoAceite::all() : TermoAceite::paginate($paginate);
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
            TermoAceite::where($where)->orWhere($orWhere)->get() :
            TermoAceite::where($where)->get();
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return TermoAceite::findOrFail($id);
    }
}