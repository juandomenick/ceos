<?php

namespace App\Services\Usuarios;

use App\Notifications\Auth\EmailVerificationNotification;
use App\Repositories\Usuarios\Interfaces\UsuarioRepositoryInterface;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Class UsuarioService
 *
 * @package App\Services\Usuarios
 */
class UsuarioService implements UsuarioServiceInterface
{
    /**
     * @var UsuarioRepositoryInterface
     */
    private $usuarioRepository;

    /**
     * UsuarioService constructor.
     *
     * @param UsuarioRepositoryInterface $usuarioRepository
     */
    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        $this->usuarioRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        $this->usuarioRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        return $this->usuarioRepository->buscar($where, $orWhere);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->usuarioRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            $usuario = User::create([
                'nome' => $dados->nome ?? null,
                'email' => $dados->email ?? null,
                'email_verified_at' => $dados->email_verified_at ?? null,
                'usuario' => $dados->usuario,
                'celular' => $dados->celular ?? null,
                'telefone' => $dados->telefone ?? null,
                'password' => Hash::make($dados->password),
                'avatar' => $dados->avatar ?? 'public/avatar_usuarios/default.png',
                'google_id' => $dados->google_id ?? null
            ]);

            if (isset($dados->funcao))
                $usuario->assignRole($dados->funcao);

            return $usuario;
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $usuario = $this->usuarioRepository->buscarPorId($id);

            if (isset($dados->avatar)) {
                if (gettype($dados->avatar) != 'string') {
                    $pathAvatar = $this->atualizarAvatar($usuario->avatar, $dados->avatar);
                } else {
                    $pathAvatar = $dados->avatar;
                }
            }

            $usuario->update([
                'nome' => $dados->nome ?? $usuario->nome,
                'email' => $dados->email ?? $usuario->email,
                'usuario' => $dados->usuario ?? $usuario->usuario,
                'celular' => $dados->celular ?? $usuario->celular,
                'telefone' => $dados->telefone ?? $usuario->telefone,
                'avatar' => $pathAvatar ?? $usuario->avatar,
                'google_id' => $dados->google_id ?? $usuario->google_id
            ]);

            if (isset($dados->funcoes))
                $usuario->syncRoles($dados->funcoes);

            return $usuario;
        });
    }

    /**
     * @inheritDoc
     */
    public function deletar(int $id): void
    {
        DB::transaction(function () use ($id) {
            $usuario = $this->usuarioRepository->buscarPorId($id);
            $usuario->delete();
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizarAvatar(string $pathAvatarAtual, object $novoAvatar): string
    {
        if ($pathAvatarAtual != 'public/avatar_usuarios/default.png') {
            Storage::delete($pathAvatarAtual);
        }

        return Storage::put('public/avatar_usuarios', $novoAvatar);
    }


    public function atualizarSenha(object $dados, int $id): User
    {
        return DB::transaction(function () use ($dados, $id) {
            $usuario = $this->usuarioRepository->buscarPorId($id);

            $usuario->update([
                'password' => Hash::make($dados->nova_senha)
            ]);

            return $usuario;
        });
    }

    /**
     * @inheritDoc
     */
    public function enviarVerificacao(User $usuario): void
    {
        $usuario->notify(new EmailVerificationNotification());
    }
}
