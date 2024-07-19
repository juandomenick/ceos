<?php

namespace App\Services\Academico;

use App\Exceptions\TransactionException;
use App\Repositories\Academico\Interfaces\CursoRepositoryInterface;
use App\Services\Academico\Interfaces\CursoServiceInterface;
use App\Services\Usuarios\Interfaces\CoordenadorServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class CursooService
 * @package App\Services\Academico
 */
class CursoService implements CursoServiceInterface
{
    /**
     * @var CursoRepositoryInterface
     */
    private $cursoRepository;
    /**
     * @var CoordenadorServiceInterface
     */
    private $coordenadorService;

    /**
     * CursooService constructor.
     *
     * @param CursoRepositoryInterface $cursoRepository
     * @param CoordenadorServiceInterface $coordenadorService
     */
    public function __construct(
        CursoRepositoryInterface $cursoRepository,
        CoordenadorServiceInterface $coordenadorService
    )
    {
        $this->cursoRepository = $cursoRepository;
        $this->coordenadorService = $coordenadorService;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->cursoRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->cursoRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        return $this->cursoRepository->buscar($where, $orWhere);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->cursoRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            if (isset($dados->coordenador_id)) {
                $coordenador = $this->coordenadorService->buscarPorId($dados->coordenador_id);
            } else {
                $dados->coordenador['instituicao'] = $dados->instituicao;
                $coordenador = $this->coordenadorService->cadastrar((object) $dados->coordenador);
            }

            $curso = $coordenador->cursos()->create([
                'nome' => $dados->nome,
                'sigla' => $dados->sigla,
                'nivel' => $dados->nivel,
                'instituicao_id' => $dados->instituicao,
            ]);

            $curso->professores()->sync($dados->professores ?? []);

            return $curso;
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $curso = $this->buscarPorId($id);

            $curso->update([
                'nome' => $dados->nome ?? $curso->nome,
                'sigla' => $dados->sigla ?? $curso->sigla,
                'nivel' => $dados->nivel ?? $curso->nivel,
                'ativo' => $dados->ativo ?? $curso->ativo,
                'coordenador_id' => $dados->coordenador_id ?? $curso->coordenador_id
            ]);

            $curso->professores()->sync($dados->professores ?? []);

            return $curso;
        });
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function deletar(int $id): void
    {
        $curso = $this->cursoRepository->buscarPorId($id);

        if ($curso->turmas)
            throw new TransactionException('O curso não pode ser removido pois está vinculado a turmas.');
        else if ($curso->disciplinas->count())
            throw new TransactionException('O curso não pode ser removido pois está vinculado a disciplinas.');

        DB::transaction(function () use ($curso) {
            $curso->delete();
        });
    }
}