<?php

namespace App\Http\Controllers\Dashboard\Academico\Turmas;

use App\DataTables\Academico\Turmas\AtividadeTurmaDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Turmas\AtividadeTurma\AtualizarAtividadeTurmaRequest;
use App\Http\Requests\Academico\Turmas\AtividadeTurma\CadastrarAtividadeTurmaRequest;
use App\Repositories\Academico\Turmas\AtividadeTurmaRepositoryEloquent;
use App\Repositories\Academico\Turmas\TurmaRepositoryEloquent;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AtividadeTurmaController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Turmas
 */
class AtividadeTurmaController extends Controller
{
    /**
     * @var AtividadeTurmaRepositoryEloquent
     */
    private $atividadeTurmaRepository;

    /**
     * @var TurmaRepositoryEloquent
     */
    private $turmaRepository;


    /**
     * AtividadeTurmaController constructor.
     *
     * @param AtividadeTurmaRepositoryEloquent $atividadeTurmaRepository
     * @param TurmaRepositoryEloquent $turmaRepository
     */
    public function __construct(AtividadeTurmaRepositoryEloquent $atividadeTurmaRepository, TurmaRepositoryEloquent $turmaRepository)
    {
        $this->middleware(['role:professor'])->only(['store', 'update', 'destroy']);

        $this->atividadeTurmaRepository = $atividadeTurmaRepository;
        $this->turmaRepository = $turmaRepository;
    }

    /**
     * Lista todas atividades de uma turma.
     *
     * @param AtividadeTurmaDataTable $atividadeTurmaDataTable
     * @param int $turmaId
     * @return mixed
     * @throws RepositoryException
     */
    public function index(AtividadeTurmaDataTable $atividadeTurmaDataTable, int $turmaId)
    {
        $turma = $this->turmaRepository->find($turmaId);

        return $atividadeTurmaDataTable
            ->with('turma', $turma)
            ->render('dashboard.academico.turmas.atividades.index', compact('turma'));
    }

    /**
     *  Exibe o formulário de cadastro da Atividade da Turma.
     *
     * @param int $turmaId
     * @return View
     * @throws RepositoryException
     */
    public function create(int $turmaId): View
    {
        $turma = $this->turmaRepository->find($turmaId);

        return view('dashboard.academico.turmas.atividades.create', compact('turma'));
    }

    /**
     * Armazena uma nova Atividade da Turma no banco de dados.
     *
     * @param CadastrarAtividadeTurmaRequest $request
     * @param int $turmaId
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarAtividadeTurmaRequest $request, int $turmaId): RedirectResponse
    {
        try {
            $this->atividadeTurmaRepository->create($request->all());

            return redirect()
                ->route('turmas.atividades.index', $turmaId)
                ->with('success', 'Atividade cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição da Atividade da Turma.
     *
     * @param int $turmaId
     * @param int $id
     * @return View
     * @throws RepositoryException
     */
    public function edit(int $turmaId, int $id): View
    {
        $atividade = $this->atividadeTurmaRepository->findById($id, $turmaId);
        $turma = $this->turmaRepository->find($turmaId);

        return view('dashboard.academico.turmas.atividades.edit')
            ->with(['atividade' => $atividade, 'turma' => $turma]);
    }

    /**
     * Atualiza uma Atividade da Turma do banco de dados.
     *
     * @param AtualizarAtividadeTurmaRequest $request
     * @param int $turmaId
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarAtividadeTurmaRequest $request, int $turmaId, int $id): RedirectResponse
    {
        try {
            $this->atividadeTurmaRepository->update($request->all(), $id);

            return redirect()
                ->route('turmas.atividades.edit', [$turmaId, $id])
                ->with('success', 'Atividade atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Atividade da Turma do banco de dados.
     *
     * @param Request $request
     * @param $turmaId
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, $turmaId, int $id): Response
    {
        try {
            $this->atividadeTurmaRepository->deleteById($id, $turmaId);
            $request->session()->flash('success', 'Atividade deletada com sucesso!');

            return response(Response::HTTP_OK);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
