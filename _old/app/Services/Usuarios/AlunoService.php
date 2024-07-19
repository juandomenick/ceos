<?php

namespace App\Services\Usuarios;

use App\Notifications\Auth\EmailVerificationNotification;
use App\Repositories\Usuarios\Interfaces\AlunoRepositoryInterface;
use App\Services\Usuarios\Interfaces\AlunoServiceInterface;
use App\Services\Usuarios\Interfaces\ResponsavelAlunoServiceInterface;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class AlunoService
 *
 * @package App\Services\Usuarios
 */
class AlunoService implements AlunoServiceInterface
{
    /**
     * @var AlunoRepositoryInterface
     */
    private $alunoRepository;
    /**
     * @var UsuarioServiceInterface
     */
    private $usuarioService;
    /**
     * @var ResponsavelAlunoServiceInterface
     */
    private $responsavelAlunoService;

    /**
     * AlunoService constructor.
     *
     * @param AlunoRepositoryInterface $alunoRepository
     * @param UsuarioServiceInterface $usuarioService
     * @param ResponsavelAlunoServiceInterface $responsavelAlunoService
     */
    public function __construct(
        AlunoRepositoryInterface $alunoRepository,
        UsuarioServiceInterface $usuarioService,
        ResponsavelAlunoServiceInterface $responsavelAlunoService
    )
    {
        $this->alunoRepository = $alunoRepository;
        $this->usuarioService = $usuarioService;
        $this->responsavelAlunoService = $responsavelAlunoService;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->alunoRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->alunoRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->alunoRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            if (isset($dados->cpf_responsavel))
                $responsavelAluno = $this->responsavelAlunoService->cadastrar($dados)->responsavelAluno;

            $dados->funcao = 'aluno';
            $usuario = $this->usuarioService->cadastrar($dados);

            $usuario->aluno()->create([
                'prontuario' => $dados->prontuario,
                'responsavel_id' => $responsavelAluno->id ?? null
            ]);

            $usuario->assignRole('aluno');

            return $usuario;
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $aluno = $this->alunoRepository->buscarPorId($id);

            $this->usuarioService->atualizar($dados, $aluno->user->id);

            $aluno->update([
                'prontuario' => $dados->prontuario ?? $aluno->prontuario
            ]);

            return $aluno;
        });
    }

    /**
     * @inheritDoc
     */
    public function deletar(int $id): void
    {
        DB::transaction(function () use ($id) {
            $aluno = $this->alunoRepository->buscarPorId($id);
            $aluno->user()->delete();
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