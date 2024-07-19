<?php

namespace App\Services\Usuarios\Interfaces;

use App\Services\BaseServiceInterface;
use App\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UsuarioServiceInterface
 *
 * @package App\Services\Usuarios\Interfaces
 */
interface UsuarioServiceInterface extends BaseServiceInterface
{
    /**
     * Atualiza avatar do Usuário
     *
     * @param string $pathAvatarAtual
     * @param object $novoAvatar
     * @return string
     */
    public function atualizarAvatar(string $pathAvatarAtual, object $novoAvatar): string;

    /**
     * Atualiza senha do Usuário.
     *
     * @param object $dados
     * @param int $id
     * @return User
     */
    public function atualizarSenha(object $dados, int $id): User;

    /**
     * Envia verificação de cadastro por e-mail.
     *
     * @param User $usuario
     */
    public function enviarVerificacao(User $usuario): void;
}