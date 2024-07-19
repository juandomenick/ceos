<?php

namespace App\Http\Controllers\Dashboard\Academico\Atividades;

use App\Criteria\Academico\Atividades\AtividadeCriteria;
use App\Criteria\Academico\Disciplinas\DisciplinaCriteria;
use App\Criteria\Academico\Questoes\QuestaoCriteria;
use App\DataTables\Academico\AtividadesDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Atividades\AtualizarAtividadeRequest;
use App\Http\Requests\Academico\Atividades\CadastrarAtividadeRequest;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeRepository;
use App\Repositories\Interfaces\Academico\DisciplinaRepository;
use App\Repositories\Interfaces\Academico\Questoes\QuestaoRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AtividadeController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Atividades
 */
class AtividadeController extends Controller
{
    /**
     * @var AtividadeRepository
     */
    private $atividadeRepository;

    /**
     * @var DisciplinaRepository
     */
    private $disciplinaRepository;

    /**
     * @var QuestaoRepository
     */
    private $questaoRepository;

    /**
     * AtividadeTurmaController constructor.
     *
     * @param AtividadeRepository $atividadeRepository
     * @param DisciplinaRepository $disciplinaRepository
     * @param QuestaoRepository $questaoRepository
     */
    public function __construct(
        AtividadeRepository $atividadeRepository,
        DisciplinaRepository $disciplinaRepository,
        QuestaoRepository $questaoRepository
    )
    {
        $this->middleware(['auth', 'role:administrador|diretor|coordenador|professor'])
            ->except('create', 'store', 'update');
        $this->middleware(['auth', 'role:professor'])
            ->only('create', 'store', 'update');

        $this->atividadeRepository = $atividadeRepository;
        $this->disciplinaRepository = $disciplinaRepository;
        $this->questaoRepository = $questaoRepository;

        $this->atividadeRepository->pushCriteria(new AtividadeCriteria());
        $this->disciplinaRepository->pushCriteria(new DisciplinaCriteria());
        $this->questaoRepository->pushCriteria(new QuestaoCriteria());
    }

    /**
     * Lista todas as Atividades.
     *
     * @param AtividadesDataTable $atividadesDataTable
     * @return mixed
     */
    public function index(AtividadesDataTable $atividadesDataTable)
    {
        return $atividadesDataTable->render('dashboard.academico.atividades.index');
    }

    /**
     * Exibe o formulário de cadastro de Atividade.
     *
     * @return View
     */
    public function create(): View
    {
        $disciplinas = $this->disciplinaRepository->all()->pluck('nome', 'id');
        $questoes = $this->questaoRepository->all()->pluck('titulo', 'id');

        return view('dashboard.academico.atividades.create', compact('disciplinas', 'questoes'));
    }

    /**
     * Armazena uma nova Atividade no banco de dados.
     *
     * @param CadastrarAtividadeRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarAtividadeRequest $request): RedirectResponse
    {
        try {
            $this->atividadeRepository->create($request->all());

            return redirect()
                ->route('atividades.index')
                ->with('success', 'Atividade cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição da Atividade.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $atividade = $this->atividadeRepository->find($id);
        $disciplinas = $this->disciplinaRepository->all()->pluck('nome', 'id');
        $questoes = $this->questaoRepository->all()->pluck('titulo', 'id');

        return view('dashboard.academico.atividades.edit', compact('atividade','disciplinas', 'questoes'));
    }

    /**
     * Atualiza uma Atividade no banco de dados.
     *
     * @param AtualizarAtividadeRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarAtividadeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->atividadeRepository->update($request->all(), $id);

            return redirect()
                ->route('atividades.edit', $id)
                ->with('success', 'Atividade atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Atividade do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $this->atividadeRepository->delete($id);
            $request->session()->flash('success', 'Atividade deletada com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
