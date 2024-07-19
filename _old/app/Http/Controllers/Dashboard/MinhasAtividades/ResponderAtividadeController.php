<?php

namespace App\Http\Controllers\Dashboard\MinhasAtividades;

use App\Http\Controllers\Controller;
use App\Http\Requests\MinhasAtividades\ResponderAtividadeRequest;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeDesignavelRepository;
use Illuminate\Http\RedirectResponse;

/**
 * Class ResponderAtividadeController
 * @package App\Http\Controllers\Dashboard\MinhasAtividades
 */
class ResponderAtividadeController extends Controller
{
    /**
     * @var AtividadeDesignavelRepository
     */
    private $atividadeDesignavelRepository;

    /**
     * AtividadesIndividuaisController constructor.
     *
     * @param AtividadeDesignavelRepository $atividadeDesignavelRepository
     */
    public function __construct(AtividadeDesignavelRepository $atividadeDesignavelRepository)
    {
        $this->atividadeDesignavelRepository = $atividadeDesignavelRepository;
    }

    /**
     * Registra respostas de Atividade.
     *
     * @param ResponderAtividadeRequest $request
     * @return RedirectResponse
     */
    public function store(ResponderAtividadeRequest $request): RedirectResponse
    {
        $this->atividadeDesignavelRepository->responder($request->all());
        return redirect()->back()->with('success', 'Respostas enviadas com sucesso!');
    }
}
