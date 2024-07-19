<?php

namespace App\Services\Geral;

use App\Models\Geral\TermoAceite;
use App\Repositories\Geral\Interfaces\TermoAceiteRepositoryInterface;
use App\Services\Geral\Interfaces\TermoAceiteServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class TermosAceiteService
 *
 * @package App\Services\Cadastros
 */
class TermoAceiteService implements TermoAceiteServiceInterface
{
    /**
     * @var TermoAceiteRepositoryInterface
     */
    private $termoAceiteRepository;

    /**
     * TermosAceiteService constructor.
     *
     * @param TermoAceiteRepositoryInterface $termoAceiteRepository
     */
    public function __construct(TermoAceiteRepositoryInterface $termoAceiteRepository)
    {
        $this->termoAceiteRepository = $termoAceiteRepository;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->termoAceiteRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->termoAceiteRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            return TermoAceite::create([
                'titulo' => $dados->titulo,
                'descricao' => $dados->descricao,
                'ativo' => true
            ]);
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $termoAceite = $this->termoAceiteRepository->buscarPorId($id);

            $termoAceite->update([
                'titulo' => $dados->titulo ?? $termoAceite->titulo,
                'descricao' => $dados->descricao ?? $termoAceite->descricao,
                'ativo' => $dados->ativo ?? $termoAceite->ativo
            ]);

            return $termoAceite;
        });
    }

    /**
     * @inheritDoc
     */
    public function deletar(int $id): void
    {
        DB::transaction(function () use ($id) {
            $termoAceite = $this->termoAceiteRepository->buscarPorId($id);
            $termoAceite->delete();
        });
    }
}