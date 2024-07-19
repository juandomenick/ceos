<?php

namespace App\Http\Controllers\Dashboard\MinhasAtividades;

use App\DataTables\MinhasAtividades\AtividadesIndividuaisDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeDesignavelRepository;
use Illuminate\View\View;

/**
 * Class AtividadesIndividuaisController
 * @package App\Http\Controllers\Dashboard\MinhasAtividades
 */
class AtividadesIndividuaisController extends Controller
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
     * Lista todas atividades individuais.
     *
     * @param AtividadesIndividuaisDataTable $atividadesIndividuaisDataTable
     * @return mixed
     */
    public function index(AtividadesIndividuaisDataTable $atividadesIndividuaisDataTable)
    {
        return $atividadesIndividuaisDataTable->render('dashboard.minhas-atividades.individuais.index');
    }

    /**
     * Exibe atividade individual.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
       $atividade = $this->atividadeDesignavelRepository->scopeQuery(function ($query) use ($id) {
            return $query->where('id', $id)->with(['atividade.questoes.respostas' => function($query) use ($id) {
                return $query->where('atividade_designada_id', $id)->where('aluno_id', auth()->user()->aluno->id);
            }]);
        })->first();

        return view('dashboard.minhas-atividades.individuais.show', compact('atividade'));
    }
}
