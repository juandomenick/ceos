<?php

namespace App\Http\Controllers\Dashboard\MinhasAtividades;

use App\DataTables\MinhasAtividades\AtividadesEquipesDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeDesignavelRepository;
use Illuminate\View\View;

/**
 * Class AtividadesEquipesController
 *
 * @package App\Http\Controllers\Dashboard\MinhasAtividades
 */
class AtividadesEquipesController extends Controller
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
     * Lista todas atividades de equipes.
     *
     * @param AtividadesEquipesDataTable $atividadesEquipesDataTable
     * @return mixed
     */
    public function index(AtividadesEquipesDataTable $atividadesEquipesDataTable)
    {
        return $atividadesEquipesDataTable->render('dashboard.minhas-atividades.equipes.index');
    }

    /**
     * Exibe atividade de equipe.
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

        return view('dashboard.minhas-atividades.equipes.show', compact('atividade'));
    }
}
