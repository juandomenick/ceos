<?php

namespace App\Http\Controllers\Dashboard\Geral\Localizacao;

use App\Http\Controllers\Controller;
use App\Http\Resources\Geral\Localizacao\EstadoResource;
use App\Services\Geral\Interfaces\EstadoServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class EstadoController
 *
 * @package App\Http\Controllers\Dashboard\Localizacao
 */
class EstadoController extends Controller
{
    /**
     * @var EstadoServiceInterface
     */
    private $estadoService;

    /**
     * EstadoController constructor.
     *
     * @param EstadoServiceInterface $estadoService
     */
    public function __construct(EstadoServiceInterface $estadoService)
    {
        $this->estadoService = $estadoService;
    }

    /**
     * Lista todos os Estados em formato JSON.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $estados = $this->estadoService->listarTodos();
        return EstadoResource::collection($estados);
    }
}
