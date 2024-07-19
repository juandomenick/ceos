<?php

namespace App\Repositories\Usuarios\Interfaces;

use App\Repositories\BaseRepositoryInterface;
use App\User;

/**
 * Interface ProfessorRepositoryInterface
 *
 * @package App\Repositories\Usuarios\Interfaces
 */
interface ProfessorRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Busca Professor pelo seu Usuário.
     *
     * @param User $user
     * @return object
     */
    public function buscarPorUser(User $user): object;
}