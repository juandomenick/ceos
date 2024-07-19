<?php

namespace App\Services\Usuarios;

use App\Exceptions\TransactionException;
use App\Repositories\Academico\Interfaces\InstituicaoRepositoryInterface;
use App\Repositories\Usuarios\Interfaces\DiretorRepositoryInterface;
use App\Services\Usuarios\Interfaces\DiretorServiceInterface;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class DiretorService
 *
 * @package App\Services\Usuarios
 */
class DiretorService implements DiretorServiceInterface
{
    /**
     * @var DiretorRepositoryInterface
     */
    private $diretorRepository;
    /**
     * @var InstituicaoRepositoryInterface
     */
    private $instituicaoRepository;
    /**
     * @var UsuarioServiceInterface
     */
    private $usuarioService;

    /**
     * DiretorService constructor.
     *
     * @param DiretorRepositoryInterface $diretorRepository
     * @param InstituicaoRepositoryInterface $instituicaoRepository
     * @param UsuarioServiceInterface $usuarioService
     */
    public function __construct(
        DiretorRepositoryInterface $diretorRepository,
        InstituicaoRepositoryInterface $instituicaoRepository,
        UsuarioServiceInterface $usuarioService

    )
    {
        $this->diretorRepository = $diretorRepository;
        $this->instituicaoRepository = $instituicaoRepository;
        $this->usuarioService = $usuarioService;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->diretorRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->diretorRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->diretorRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            if (isset($dados->professor)) {
                $dados->funcoes = ['professor', 'diretor'];
                return $this->usuarioService->atualizar($dados, $dados->professor);
            } else {
                $dados->funcao = 'diretor';
                $diretor = $this->usuarioService->cadastrar($dados);
                $this->usuarioService->enviarVerificacao($diretor);

                return $diretor;
            }
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            return $this->usuarioService->atualizar($dados, $id);
        });
    }

    /**
     * @inheritDoc
     * @throws TransactionException
     */
    public function deletar(int $id): void
    {
        if ($this->instituicaoRepository->buscar([['diretor_id', $id]])->count())
            throw new TransactionException('O diretor não pode ser removido pois está vinculado a uma instituição.');

        DB::transaction(function () use ($id) {
            $diretor = $this->buscarPorId($id);
            $diretor->removeRole('diretor');
        });
    }
}