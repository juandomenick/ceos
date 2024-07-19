<?php

namespace App\Services\Geral;

use App\Repositories\Geral\Interfaces\CidadeRepositoryInterface;
use App\Services\Geral\Interfaces\CidadeServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CidadeService
 *
 * @package App\Services\Localizacao
 */
class CidadeService implements CidadeServiceInterface
{
    /**
     * @var CidadeRepositoryInterface
     */
    private $cidadeRepository;

    /**
     * CidadeService constructor.
     *
     * @param CidadeRepositoryInterface $cidadeRepository
     */
    public function __construct(CidadeRepositoryInterface $cidadeRepository)
    {
        $this->cidadeRepository = $cidadeRepository;
    }

    /**
     * @inheritDoc
     */
    public function buscarPorEstado(int $estadoId): Collection
    {
        return $this->cidadeRepository->buscarPorEstado($estadoId);
    }
}