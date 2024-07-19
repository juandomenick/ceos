<?php

namespace App\Services\Usuarios;

use App\Exceptions\TransactionException;
use App\Repositories\Academico\Interfaces\CursoRepositoryInterface;
use App\Repositories\Usuarios\Interfaces\CoordenadorRepositoryInterface;
use App\Services\Usuarios\Interfaces\CoordenadorServiceInterface;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class CoordenadorService
 *
 * @package App\Services\Usuarios
 */
class CoordenadorService implements CoordenadorServiceInterface
{
    /**
     * @var CoordenadorRepositoryInterface
     */
    private $coordenadorRepository;
    /**
     * @var CursoRepositoryInterface
     */
    private $cursoRepository;
    /**
     * @var UsuarioServiceInterface
     */
    private $usuarioService;

    /**
     * CoordenadorService constructor.
     *
     * @param CoordenadorRepositoryInterface $coordenadorRepository
     * @param CursoRepositoryInterface $cursoRepository
     * @param UsuarioServiceInterface $usuarioService
     */
    public function __construct(
        CoordenadorRepositoryInterface $coordenadorRepository,
        CursoRepositoryInterface $cursoRepository,
        UsuarioServiceInterface $usuarioService
    )
    {
        $this->coordenadorRepository = $coordenadorRepository;
        $this->usuarioService = $usuarioService;
        $this->cursoRepository = $cursoRepository;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->coordenadorRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->coordenadorRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        return $this->coordenadorRepository->buscar($where, $orWhere);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->coordenadorRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            if (isset($dados->professor)) {
                $dados->funcoes = ['professor', 'coordenador'];

                $usuario = $this->usuarioService->atualizar($dados, $dados->professor);
                $usuario->coordenador()->create(['instituicao_id' => $dados->instituicao]);
            } else {
                $dados->funcao = 'coordenador';

                $usuario = $this->usuarioService->cadastrar($dados);
                $this->usuarioService->enviarVerificacao($usuario);

                $usuario->coordenador()->create(['instituicao_id' => $dados->instituicao]);
            }

            return $usuario->coordenador;
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $coordenador = $this->buscarPorId($id);
            return $this->usuarioService->atualizar($dados, $coordenador->user->id);
        });
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deletar(int $id): void
    {
        if ($this->cursoRepository->buscar([['coordenador_id', $id]])->count())
            throw new TransactionException('O coordenador não pode ser removido pois está vinculado a um curso.');

        DB::transaction(function () use ($id) {
            $coordenador = $this->buscarPorId($id);
            $coordenador->user->removeRole('coordenador');
            $coordenador->delete();
        });
    }
}