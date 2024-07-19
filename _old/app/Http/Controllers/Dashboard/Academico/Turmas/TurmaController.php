<?php

namespace App\Http\Controllers\Dashboard\Academico\Turmas;

use App\DataTables\Academico\Turmas\TurmaDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Turmas\Turma\AtualizarTurmaRequest;
use App\Http\Requests\Academico\Turmas\Turma\CadastrarTurmaRequest;
use App\Repositories\Academico\InstituicaoRepositoryEloquent;
use App\Repositories\Academico\Turmas\TurmaRepositoryEloquent;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TurmaController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Turmas
 */
class TurmaController extends Controller
{
    /**
     * @var TurmaRepositoryEloquent
     */
    private $turmaRepository;

    /**
     * @var InstituicaoRepositoryEloquent
     */
    private $instituicaoRepository;

    /**
     * @var string[]
     */
    private $status = [true => 'Ativo', false => 'Inativo'];

    /**
     * TurmaController constructor.
     *
     * @param TurmaRepositoryEloquent $turmaRepository
     * @param InstituicaoRepositoryEloquent $instituicaoRepository
     */
    public function __construct(
        TurmaRepositoryEloquent $turmaRepository,
        InstituicaoRepositoryEloquent $instituicaoRepository
    )
    {
        $this->middleware(['role:administrador|diretor|coordenador|aluno'])->except(['index', 'edit', 'update']);
        $this->middleware(['role:administrador|diretor|coordenador|professor|aluno'])->only(['index', 'edit', 'update']);

        $this->turmaRepository = $turmaRepository;
        $this->instituicaoRepository = $instituicaoRepository;
    }

    /**
     * Lista todas as Turmas.
     *
     * @param TurmaDataTable $turmaDataTable
     * @return mixed
     */
    public function index(TurmaDataTable $turmaDataTable)
    {
        return $turmaDataTable->render('dashboard.academico.turmas.index');
    }

    /**
     * Exibe formulário de cadastro de Turma.
     *
     * @return View
     */
    public function create(): View
    {
        $instituicoes = $this->instituicaoRepository->pluck('nome', 'id');

        return view('dashboard.academico.turmas.create')
            ->with(['instituicoes' => $instituicoes, 'status' => $this->status]);
    }

    /**
     * Armazena uma nova Turma no banco de dados.
     *
     * @param CadastrarTurmaRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarTurmaRequest $request): RedirectResponse
    {
        try {
            $this->turmaRepository->create($request->all());
            return redirect()->route('turmas.index')->with('success', 'Turma cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }


    /**
     * Exibe formulário de edição de Turma.
     *
     * @param int $id
     * @return View
     * @throws RepositoryException
     */
    public function edit(int $id): View
    {
        $turma = $this->turmaRepository->find($id);
        $instituicoes = $this->instituicaoRepository->pluck('nome', 'id');

        if (!collect($turma)->has('semestre')) {
            $statusTurma = [
                'ACTIVE' => 'Ativo',
                'ARCHIVED' => 'Arquivado',
                'PROVISIONED' => 'Provisionado',
                'DECLINED' => 'Recusado',
                'SUSPENDED' => 'Suspenso'
            ];
        }

        return view('dashboard.academico.turmas.edit')
            ->with(['turma' => $turma, 'instituicoes' => $instituicoes, 'status' => $statusTurma ?? $this->status]);
    }

    /**
     * Atualizar uma Turma no banco de dados.
     *
     * @param AtualizarTurmaRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarTurmaRequest $request, int $id): RedirectResponse
    {
        try {
            $this->turmaRepository->update($request->all(), $id);
            return redirect()->route('turmas.edit', $id)->with('success', 'Turma atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Turma do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->turmaRepository->delete($id);
            $request->session()->flash('success', 'Turma deletada com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
