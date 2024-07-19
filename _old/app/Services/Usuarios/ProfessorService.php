<?php

namespace App\Services\Usuarios;

use App\Notifications\Auth\EmailVerificationNotification;
use App\Repositories\Usuarios\Interfaces\ProfessorRepositoryInterface;
use App\Services\Usuarios\Interfaces\ProfessorServiceInterface;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class ProfessorService
 *
 * @package App\Services\Usuarios
 */
class ProfessorService implements ProfessorServiceInterface
{
    /**
     * @var UsuarioServiceInterface
     */
    private $usuarioService;
    /**
     * @var ProfessorRepositoryInterface
     */
    private $professorRepository;

    /**
     * ProfessorService constructor.
     *
     * @param UsuarioServiceInterface $usuarioService
     * @param ProfessorRepositoryInterface $professorRepository
     */
    public function __construct(
        UsuarioServiceInterface $usuarioService,
        ProfessorRepositoryInterface $professorRepository
    )
    {
        $this->usuarioService = $usuarioService;
        $this->professorRepository = $professorRepository;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->professorRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->professorRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->professorRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            $dados->funcao = 'professor';
            $usuario = $this->usuarioService->cadastrar($dados);

            $usuario->professor()->create(['matricula' => $dados->matricula]);

            return $usuario;
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $professor = $this->professorRepository->buscarPorId($id);

            $this->usuarioService->atualizar($dados, $professor->user->id);

            $professor->update([
                'matricula' => $dados->matricula ?? $professor->matricula
            ]);

            return $professor;
        });
    }

    /**
     * @inheritDoc
     */
    public function deletar(int $id): void
    {
        DB::transaction(function () use ($id) {
            $professor = $this->professorRepository->buscarPorId($id);
            $professor->user()->delete();
        });
    }

    /**
     * @param User $usuario
     */
    public function enviarVerificacao(User $usuario): void
    {
        $usuario->notify(new EmailVerificationNotification());
    }
}