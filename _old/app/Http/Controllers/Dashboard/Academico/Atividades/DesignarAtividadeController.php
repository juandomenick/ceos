<?php

namespace App\Http\Controllers\Dashboard\Academico\Atividades;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Atividades\Designar\AtualizarAtividadeDesignadaRequest;
use App\Http\Requests\Academico\Atividades\Designar\CadastrarAtividadeDesignadaRequest;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeDesignavelRepository;
use App\Repositories\Interfaces\Academico\EquipeRepository;
use App\Repositories\Interfaces\Academico\Turmas\TurmaRepository;
use App\Repositories\Interfaces\Usuarios\AlunoRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class DesignarAtividadeController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Atividades
 */
class DesignarAtividadeController extends Controller
{
    /**
     * @var AtividadeDesignavelRepository
     */
    private $atividadeDesignavelRepository;

    /**
     * @var TurmaRepository
     */
    private $turmaRepository;

    /**
     * @var EquipeRepository
     */
    private $equipeRepository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * DesignarAtividadeController constructor.
     *
     * @param AtividadeDesignavelRepository $atividadeDesignavelRepository
     * @param TurmaRepository $turmaRepository
     * @param EquipeRepository $equipeRepository
     * @param AlunoRepository $alunoRepository
     */
    public function __construct(
        AtividadeDesignavelRepository $atividadeDesignavelRepository,
        TurmaRepository $turmaRepository,
        EquipeRepository $equipeRepository,
        AlunoRepository $alunoRepository
    )
    {
        $this->middleware(['auth', 'role:administrador|diretor|coordenador|professor'])
            ->except('create', 'store', 'update');
        $this->middleware(['auth', 'role:professor'])
            ->only('create', 'store', 'update');

        $this->atividadeDesignavelRepository = $atividadeDesignavelRepository;
        $this->turmaRepository = $turmaRepository;
        $this->equipeRepository = $equipeRepository;
        $this->alunoRepository = $alunoRepository;
    }

    /**
     * Exibe o formulário de cadastro para Designar Atividade.
     *
     * @param int $atividadeId
     * @return View
     */
    public function create(int $atividadeId): View
    {
        $turmas = $this->turmaRepository->scopeQuery(function ($query) {
            return $query;
        })->pluck('nome', 'id');
        $equipes = $this->equipeRepository->all()->pluck('nome', 'id');
        $alunos = $this->alunoRepository->all()->pluck('user.nome', 'id');

        return view('dashboard.academico.atividades.designar.create', compact('atividadeId', 'turmas', 'equipes', 'alunos'));
    }

    /**
     * Armazena uma nova Atividade Designavel no banco de dados.
     *
     * @param CadastrarAtividadeDesignadaRequest $request
     * @param int $atividadeId
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarAtividadeDesignadaRequest $request, int $atividadeId): RedirectResponse
    {
        try {
            $this->atividadeDesignavelRepository->create($request->all());

            return redirect()
                ->route('atividades.index')
                ->with(['success' => 'Atividade designada com sucesso!', 'atividadeId' => $atividadeId]);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição da Atividade Designada.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Atualiza uma Atividade Designada no banco de dados.
     *
     * @param AtualizarAtividadeDesignadaRequest $request
     * @param int $id
     * @return void
     */
    public function update(AtualizarAtividadeDesignadaRequest $request, int $id)
    {
        //
    }

    /**
     * Remove uma Atividade Designada do banco de dados.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        //
    }
}
