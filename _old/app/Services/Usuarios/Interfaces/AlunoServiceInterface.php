<?php

namespace App\Services\Usuarios\Interfaces;

use App\Services\BaseServiceInterface;
use App\User;

/**
 * Interface AlunoServiceInterface
 *
 * @package App\Services\Usuarios\Interfaces
 */
interface AlunoServiceInterface extends BaseServiceInterface
{
    /**
     * Envia verificação de cadastro por e-mail.
     *
     * @param User $usuario
     */
    public function enviarVerificacao(User $usuario): void;
}