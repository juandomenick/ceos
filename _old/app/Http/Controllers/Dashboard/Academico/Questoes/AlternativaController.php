<?php

namespace App\Http\Controllers\Dashboard\Academico\Questoes;

use App\Criteria\Academico\Questoes\AlternativaCriteria;
use App\Criteria\Academico\Questoes\QuestaoCriteria;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Questoes\Alternativas\AtualizarAlternativaRequest;
use App\Http\Requests\Academico\Questoes\Alternativas\CadastrarAlternativaRequest;
use App\Repositories\Academico\Questoes\AlternativaRepositoryEloquent;
use App\Repositories\Academico\Questoes\QuestaoRepositoryEloquent;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;

class AlternativaController extends Controller
{
    /**
     * @var AlternativaRepositoryEloquent
     */
    private $alternativaRepository;

    /**
     * @var QuestaoRepositoryEloquent
     */
    private $questaoRepository;

    /**
     * AlternativaController constructor.
     *
     * @param AlternativaRepositoryEloquent $alternativaRepository
     * @param QuestaoRepositoryEloquent $questaoRepository
     */
    public function __construct(
        AlternativaRepositoryEloquent $alternativaRepository,
        QuestaoRepositoryEloquent $questaoRepository
    )
    {
        $this->middleware(['auth', 'role:administrador|diretor|coordenador|professor'])
            ->except('create', 'store', 'update');
        $this->middleware(['auth', 'role:professor'])
            ->only('create', 'store', 'update');

        $this->alternativaRepository = $alternativaRepository;
        $this->questaoRepository = $questaoRepository;
    }

    /**
     * Exibe formulário de cadastro da Alternativa.
     *
     * @param int $questaoId
     * @return View
     * @throws RepositoryException
     */
    public function create(int $questaoId): View
    {
        $this->questaoRepository->pushCriteria(new QuestaoCriteria());

        $questao = $this->questaoRepository->find($questaoId);

        return view('dashboard.academico.questoes.alternativas.create', compact('questao'));
    }

    /**
     * Armazena uma nova Alternativa no banco de dados.
     *
     * @param CadastrarAlternativaRequest $request
     * @param int $questaoId
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarAlternativaRequest $request, int $questaoId): RedirectResponse
    {
        try {
            $this->alternativaRepository->create($request->all());
            return redirect()->back()->with('success', 'Alternativa cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe formulário de edição da Alternativa.
     *
     * @param int $questaoId
     * @param int $alternativaId
     * @return View
     * @throws RepositoryException
     */
    public function edit(int $questaoId, int $alternativaId): View
    {
        $this->alternativaRepository->pushCriteria(new AlternativaCriteria());
        $this->questaoRepository->pushCriteria(new QuestaoCriteria());

        $questao = $this->questaoRepository->find($questaoId);
        $alternativa = $this->alternativaRepository->find($alternativaId);

        return view('dashboard.academico.questoes.alternativas.edit', compact('alternativa', 'questao'));
    }

    /**
     * Atualiza uma Alternativa no Banco de Dados.
     *
     * @param AtualizarAlternativaRequest $request
     * @param int $questaoId
     * @param int $alternativaId
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarAlternativaRequest $request, int $questaoId, int $alternativaId): RedirectResponse
    {
        try {
            $this->alternativaRepository->update($request->all(), $alternativaId);

            return redirect()->back()->with('success', 'Alternativa atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Alternativa do Banco de Dados.
     *
     * @param Request $request
     * @param int $questaoId
     * @param int $alternativaId
     * @return JsonResponse
     * @throws TransactionException
     */
    public function destroy(Request $request, int $questaoId, int $alternativaId): JsonResponse
    {
        try {
            $this->alternativaRepository->delete($alternativaId);

            $request->session()->flash('success', 'Alternativa deletada com sucesso!');

            return response()->json(['redirect' => route('questoes.edit', $questaoId)]);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
