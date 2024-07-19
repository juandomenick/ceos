<?php

namespace App\Http\Controllers\Dashboard\Academico\Questoes;

use App\Criteria\Academico\Questoes\QuestaoCriteria;
use App\DataTables\Academico\QuestoesDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Academico\Questoes\AtualizarQuestaoRequest;
use App\Http\Requests\Academico\Questoes\CadastrarQuestaoRequest;
use App\Repositories\Academico\HabilidadeRepositoryEloquent;
use App\Repositories\Academico\Questoes\QuestaoRepositoryEloquent;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuestaoController
 *
 * @package App\Http\Controllers\Academico
 */
class QuestaoController extends Controller
{
    /**
     * @var QuestaoRepositoryEloquent
     */
    private $questaoRepository;

    /**
     * QuestaosController constructor.
     *
     * @param QuestaoRepositoryEloquent $questaoRepository
     */
    public function __construct(QuestaoRepositoryEloquent $questaoRepository)
    {
        $this->middleware(['auth', 'role:administrador|diretor|coordenador|professor'])
            ->except('create', 'store', 'update', 'duplicate');
        $this->middleware(['auth', 'role:professor'])
            ->only('create', 'store', 'update', 'duplicate');

        $this->questaoRepository = $questaoRepository;
    }

    /**
     * Lista todas as Questões.
     *
     * @param QuestoesDataTable $questoesDataTable
     * @return mixed
     */
    public function index(QuestoesDataTable $questoesDataTable)
    {
        return $questoesDataTable->render('dashboard.academico.questoes.index');
    }

    /**
     * Exibe o formulário de cadastro da Questão.
     *
     * @param HabilidadeRepositoryEloquent $habilidadeRepository
     * @return View
     */
    public function create(HabilidadeRepositoryEloquent $habilidadeRepository): View
    {
        $habilidades = $habilidadeRepository->all(['id', 'descricao'])->pluck('descricao', 'id');
        return view('dashboard.academico.questoes.create', compact('habilidades'));
    }

    /**
     * Armazena uma nova Questão no banco de dados.
     *
     * @param CadastrarQuestaoRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarQuestaoRequest $request): RedirectResponse
    {
        try {
            $this->questaoRepository->create($request->all());
            return redirect()->route('questoes.index')->with('success', 'Questão cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição da Questão.
     *
     * @param HabilidadeRepositoryEloquent $habilidadeRepository
     * @param int $id
     * @return View
     */
    public function edit(HabilidadeRepositoryEloquent $habilidadeRepository, int $id): View
    {
        $questao = $this->questaoRepository->find($id);
        $habilidades = $habilidadeRepository->all(['id', 'descricao'])->pluck('descricao', 'id');

        return view('dashboard.academico.questoes.edit', compact('questao', 'habilidades'));
    }

    /**
     * Atualiza uma Questão do banco de dados.
     *
     * @param AtualizarQuestaoRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarQuestaoRequest $request, int $id): RedirectResponse
    {
        try {
            $this->questaoRepository->update($request->all(), $id);

            return redirect()
                ->route('questoes.edit', $id)
                ->with('success', 'Questão atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Questão do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->questaoRepository->pushCriteria(new QuestaoCriteria());

            $this->questaoRepository->delete($id);
            $request->session()->flash('success', 'Questão deletada com sucesso!');

            return response(Response::HTTP_OK);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Duplica uma questão.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function duplicate(int $id): RedirectResponse
    {
        try {
            $this->questaoRepository->duplicate($id);

            return redirect()
                ->back()
                ->with('success', 'Questão duplicada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
