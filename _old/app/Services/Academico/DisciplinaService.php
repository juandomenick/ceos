<?php

namespace App\Services\Academico;

use App\Exceptions\TransactionException;
use App\Models\Academico\Disciplina;
use App\Repositories\Academico\Interfaces\DisciplinaRepositoryInterface;
use App\Services\Academico\Interfaces\DisciplinaServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class DisciplinaService
 *
 * @package App\Services\Academico
 */
class DisciplinaService implements DisciplinaServiceInterface
{
    /**
     * @var DisciplinaRepositoryInterface
     */
    private $disciplinaRepository;

    /**
     * DisciplinaService constructor.
     *
     * @param DisciplinaRepositoryInterface $disciplinaRepository
     */
    public function __construct(DisciplinaRepositoryInterface $disciplinaRepository)
    {
        $this->disciplinaRepository = $disciplinaRepository;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->disciplinaRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->disciplinaRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->disciplinaRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            return Disciplina::create((array) $dados);
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $disciplina = $this->buscarPorId($id);

            $disciplina->update([
                'nome' => $dados->nome ?? $disciplina->nome,
                'sigla' => $dados->sigla ?? $disciplina->sigla,
                'ativo' => $dados->ativo ?? $disciplina->ativo,
                'curso_id' => $dados->curso_id ?? $disciplina->curso_id,
            ]);

            return $disciplina;
        });
    }

    /**
     * @inheritDoc
     */
    public function deletar(int $id): void
    {
        $disciplina = $this->disciplinaRepository->buscarPorId($id);

        if ($disciplina->turmas->count())
            throw new TransactionException('A disciplina não pode ser removida pois está vinculado a turmas.');

        DB::transaction(function () use ($disciplina) {
            $disciplina->delete();
        });
    }
}