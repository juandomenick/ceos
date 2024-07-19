<?php

namespace App\Repositories\Usuarios\Interfaces;

use App\Repositories\BaseRepositoryInterface;
use App\User;

/**
 * Interface ResponsavelAlunoRepositoryInterface
 *
 * @package App\Repositories\Usuarios\Interfaces
 */
interface ResponsavelAlunoRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Busca Responsável pelo seu Usuário.
     *
     * @param User $user
     * @return object
     */
    public function buscarPorUser(User $user): object;
}