<?php

namespace App\Http\Controllers\Dashboard\Academico\AnotacoesAula;

use App\DataTables\Academico\AnotacaoAulaDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\AnotacoesAula\AtualizarAnotacaoAulaRequest;
use App\Http\Requests\Academico\AnotacoesAula\CadastrarAnotacaoAulaRequest;
use App\Repositories\Academico\AnotacaoAulaRepositoryEloquent;
use App\Repositories\Academico\Turmas\TurmaRepositoryEloquent;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AnotacaoAulaController extends Controller
{
    /**
     * @var AnotacaoAulaRepositoryEloquent
     */
    private $anotacaoAulaRepository;

    /**
     * @var TurmaRepositoryEloquent
     */
    private $turmaRepository;

    /**
     * AnotacaoAulaController constructor.
     *
     * @param AnotacaoAulaRepositoryEloquent $aulaRepositoryEloquent
     * @param TurmaRepositoryEloquent $turmaRepository
     */
    public function __construct(
        AnotacaoAulaRepositoryEloquent $aulaRepositoryEloquent,
        TurmaRepositoryEloquent $turmaRepository
    )
    {
        $this->middleware(['auth', 'role:administrador|diretor|coordenador|professor'])
            ->except('create', 'store', 'update');
        $this->middleware(['auth', 'role:professor'])
            ->only('create', 'store', 'update');

        $this->anotacaoAulaRepository = $aulaRepositoryEloquent;
        $this->turmaRepository = $turmaRepository;
    }

    /**
     * Lista todas as anotações de aula.
     *
     * @param AnotacaoAulaDataTable $anotacaoAulaDataTable
     * @return mixed
     */
    public function index(AnotacaoAulaDataTable $anotacaoAulaDataTable)
    {
        return $anotacaoAulaDataTable->render('dashboard.academico.anotacoes-aula.index');
    }

    /**
     * Exibe formulário de cadastro de Equipe.
     *
     * @return View
     */
    public function create(): View
    {
        $turmas = $this->turmaRepository->all()->pluck('nome', 'id');
        return view('dashboard.academico.anotacoes-aula.create', compact('turmas'));
    }

    /**
     * Armazena uma nova Anotação no banco de dados.
     *
     * @param CadastrarAnotacaoAulaRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarAnotacaoAulaRequest $request)
    {
        try {
            $this->anotacaoAulaRepository->create($request->all());

            return redirect()
                ->route('anotacoes-aula.index')
                ->with('success', 'Anotação cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição da Anotação.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $anotacao = $this->anotacaoAulaRepository->find($id);
        $turmas = $this->turmaRepository->all()->pluck('nome', 'id');

        return view('dashboard.academico.anotacoes-aula.edit', compact('anotacao','turmas'));
    }

    /**
     * Atualiza uma Anotação no banco de dados.
     *
     * @param AtualizarAnotacaoAulaRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarAnotacaoAulaRequest $request, int $id): RedirectResponse
    {
        try {
            $this->anotacaoAulaRepository->update($request->all(), $id);

            return redirect()
                ->route('anotacoes-aula.edit', $id)
                ->with('success', 'Anotação atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Anotação do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $this->anotacaoAulaRepository->delete($id);
            $request->session()->flash('success', 'Anotação deletada com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
