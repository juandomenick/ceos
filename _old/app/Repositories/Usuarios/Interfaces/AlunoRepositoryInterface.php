<?php

namespace App\Repositories\Usuarios\Interfaces;

use App\Repositories\BaseRepositoryInterface;
use App\User;

/**
 * Interface AlunoRepositoryInterface
 * @package App\Repositories\Usuarios\Interfaces
 */
interface AlunoRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Busca Aluno pelo seu Usuário.
     *
     * @param User $user
     * @return object
     */
    public function buscarPorUser(User $user): object;
}