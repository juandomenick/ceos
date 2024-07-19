<?php

namespace App\Services\Academico;

use App\Models\Academico\Instituicao;
use App\Repositories\Academico\Interfaces\InstituicaoRepositoryInterface;
use App\Services\Academico\Interfaces\InstituicaoServiceInterface;
use App\Services\Usuarios\DiretorService;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class InstituicaoService
 *
 * @package App\Services\Academico
 */
class InstituicaoService implements InstituicaoServiceInterface
{
    /**
     * @var InstituicaoRepositoryInterface
     */
    private $instituicaoRepository;
    /**
     * @var UsuarioServiceInterface
     */
    private $usuarioService;
    /**
     * @var DiretorService
     */
    private $diretorService;

    /**
     * InstituicaoService constructor.
     *
     * @param InstituicaoRepositoryInterface $instituicaoRepository
     * @param UsuarioServiceInterface $usuarioService
     * @param DiretorService $diretorService
     */
    public function __construct(
        InstituicaoRepositoryInterface $instituicaoRepository,
        UsuarioServiceInterface $usuarioService,
        DiretorService $diretorService
    )
    {
        $this->instituicaoRepository = $instituicaoRepository;
        $this->usuarioService = $usuarioService;
        $this->diretorService = $diretorService;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(int $paginate = null): object
    {
        return $this->instituicaoRepository->listarTodos($paginate);
    }

    /**
     * @inheritDoc
     */
    public function filtrar(array $parametros, int $paginate = null): object
    {
        return $this->instituicaoRepository->filtrar($parametros, $paginate);
    }

    /**
     * @inheritDoc
     */
    public function buscar(array $where, array $orWhere = []): object
    {
        return $this->instituicaoRepository->buscar($where, $orWhere);
    }

    /**
     * @inheritDoc
     */
    public function buscarPorId(int $id): Model
    {
        return $this->instituicaoRepository->buscarPorId($id);
    }

    /**
     * @inheritDoc
     */
    public function cadastrar(object $dados): Model
    {
        return DB::transaction(function () use ($dados) {
            if (isset($dados->diretor_id)) {
                $diretor = $this->diretorService->buscarPorId($dados->diretor_id);
            } else {
                $diretor = $this->diretorService->cadastrar((object) $dados->diretor);
            }

            return $diretor->instituicoes()->create([
                'nome' => $dados->nome,
                'sigla' => $dados->sigla,
                'telefone' => $dados->telefone,
                'cidade_id' => $dados->cidades
            ]);
        });
    }

    /**
     * @inheritDoc
     */
    public function atualizar(object $dados, int $id): Model
    {
        return DB::transaction(function () use ($dados, $id) {
            $instituicao = $this->instituicaoRepository->buscarPorId($id);

            $instituicao->update([
                'nome' => $dados->nome ?? $instituicao->nome,
                'sigla' => $dados->sigla ?? $instituicao->sigla,
                'telefone' => $dados->telefone ?? $instituicao->telefone,
                'ativo' => $dados->ativo ?? $instituicao->ativo,
                'cidade_id' => $dados->cidades ?? $instituicao->cidade_id,
                'diretor_id' => $dados->diretor ?? $instituicao->diretor_id
            ]);

            return $instituicao;
        });
    }

    /**
     * @inheritDoc
     */
    public function deletar(int $id): void
    {
        Instituicao::destroy($id);
    }
}