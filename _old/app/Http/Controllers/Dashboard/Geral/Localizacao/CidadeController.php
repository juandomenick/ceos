<?php

namespace App\Http\Controllers\Dashboard\Geral\Localizacao;

use App\Http\Controllers\Controller;
use App\Http\Resources\Geral\Localizacao\CidadeResource;
use App\Services\Geral\Interfaces\CidadeServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class CidadeController
 *
 * @package App\Http\Controllers\Dashboard\Localizacao
 */
class CidadeController extends Controller
{
    /**
     * @var CidadeServiceInterface
     */
    private $cidadeService;

    /**
     * CidadeController constructor.
     *
     * @param CidadeServiceInterface $cidadeService
     */
    public function __construct(CidadeServiceInterface $cidadeService)
    {
        $this->cidadeService = $cidadeService;
    }

    /**
     * Retorna Cidades de um determinado Estado em formato JSON.
     *
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function listarPorEstado(int $id): AnonymousResourceCollection
    {
        $cidades = $this->cidadeService->buscarPorEstado($id);
        return CidadeResource::collection($cidades);
    }
}
