<?php

namespace App\Services\Usuarios;

use App\Repositories\Usuarios\Interfaces\ResponsavelAlunoRepositoryInterface;
use App\Repositories\Usuarios\Interfaces\UsuarioRepositoryInterface;
use App\Services\Usuarios\Interfaces\ResponsavelAlunoServiceInterface;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class ResponsavelAlunoService
 *
 * @package App\Services\Usuarios
 */
class ResponsavelAlunoService implements ResponsavelAlunoServiceInterface
{
    /**
     * @var ResponsavelAlunoRepositoryInterface
     */
    private $reponsavelRepository;
    /**
     * @var UsuarioServiceInterface
     */
    private $usuarioService;
    /**
     * @var UsuarioRepositoryInterface
     */
    private $usuarioRepository;

    /**
     * ResponsavelAlunoService constructor.
     *
     * @param ResponsavelAlunoRepositoryInterface $reponsavelRepository
     * @param UsuarioServiceInterface $usuarioService
     * @param UsuarioRepositoryInterface $usuarioRepository
     */
    public function __construct(
        ResponsavelAlunoRepositoryInterface $reponsavelRepository,
        UsuarioServiceInterface $usuarioService,
        UsuarioRepositoryInterface $usuarioRepository
    )
    {
        $this->reponsavelRepository = $reponsavelRepository;
        $this->usuarioService = $usuarioService;
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->reponsavelRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->reponsavelRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->reponsavelRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            $cpfSomenteNumeros = preg_replace("/[^0-9]/", "", $dados->cpf_responsavel);

            $dadosResponsavel = [
                'usuario' => $dados->cpf_responsavel,
                'password' => $cpfSomenteNumeros,
                'email_verified_at' => date('Y-m-d h:i:s'),
                'funcao' => 'responsavel-aluno'
            ];

            $usuario = $this->usuarioRepository->buscar([['usuario', '=', $dados->cpf_responsavel]])->first();

            if (!$usuario) {
                $usuario = $this->usuarioService->cadastrar((object) $dadosResponsavel);
                $usuario->responsavelAluno()->create([])->user;
            }

            return $usuario;
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $responsavel = $this->reponsavelRepository->buscarPorId($id);

            $this->usuarioService->atualizar($dados, $responsavel->user->id);

            return $responsavel;
        });
    }

    /**
     * @inheritDoc
     */
    public function deletar(int $id): void
    {
        DB::transaction(function () use ($id) {
            $responsavel = $this->reponsavelRepository->buscarPorId($id);
            $responsavel->user()->delete();
        });
    }
}