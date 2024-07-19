<?php

namespace App\Repositories\Usuarios\Interfaces;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UsuarioRepositoryInterface
 *
 * @package App\Repositories\Usuarios\Interfaces
 */
interface UsuarioRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Busca Usuários a partir das funções passadas no parâmetro $roles.
     *
     * @param array $roles
     * @return Collection
     */
    public function buscarPorRoles(array $roles): Collection;
}