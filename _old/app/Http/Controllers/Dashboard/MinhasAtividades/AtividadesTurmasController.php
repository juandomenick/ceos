<?php

namespace App\Http\Controllers\Dashboard\MinhasAtividades;

use App\DataTables\MinhasAtividades\AtividadesTurmasDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeDesignavelRepository;
use Illuminate\View\View;

/**
 * Class AtividadesTurmasController
 *
 * @package App\Http\Controllers\Dashboard\MinhasAtividades
 */
class AtividadesTurmasController extends Controller
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
     * Lista todas atividades de turmas.
     *
     * @param AtividadesTurmasDataTable $atividadesTurmasDataTable
     * @return mixed
     */
    public function index(AtividadesTurmasDataTable $atividadesTurmasDataTable)
    {
        return $atividadesTurmasDataTable->render('dashboard.minhas-atividades.turmas.index');
    }

    /**
     * Exibe atividade de turma.
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

        return view('dashboard.minhas-atividades.turmas.show', compact('atividade'));
    }
}
