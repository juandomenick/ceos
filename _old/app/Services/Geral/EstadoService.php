<?php

namespace App\Services\Geral;

use App\Repositories\Geral\Interfaces\EstadoRepositoryInterface;
use App\Services\Geral\Interfaces\EstadoServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EstadoService
 *
 * @package App\Services\Localizacao\Interfaces
 */
class EstadoService implements EstadoServiceInterface
{
    /**
     * @var EstadoRepositoryInterface
     */
    private $estadoRepository;

    /**
     * EstadoService constructor.
     *
     * @param EstadoRepositoryInterface $estadoRepository
     */
    public function __construct(EstadoRepositoryInterface $estadoRepository)
    {
        $this->estadoRepository = $estadoRepository;
    }

    /**
     * @inheritDoc
     */
    public function listarTodos(): Collection
    {
        return $this->estadoRepository->listarTodos();
    }
}