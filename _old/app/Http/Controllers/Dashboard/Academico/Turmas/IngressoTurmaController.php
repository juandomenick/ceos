<?php

namespace App\Http\Controllers\Dashboard\Academico\Turmas;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Turmas\IngressoTurma\IngressarTurmaRequest;
use App\Repositories\Academico\Turmas\TurmaRepositoryEloquent;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class IngressoTurmaController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Turmas
 */
class IngressoTurmaController extends Controller
{
    /**
     * @var TurmaRepositoryEloquent
     */
    private $turmaRepository;

    /**
     * IngressoTurmaController constructor.
     *
     * @param TurmaRepositoryEloquent $turmaRepository
     */
    public function __construct(TurmaRepositoryEloquent $turmaRepository)
    {
        $this->turmaRepository = $turmaRepository;
    }

    /**
     * Exibe formulário para ingresso em Turma.
     *
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.academico.turmas.ingresso.index');
    }

    /**
     * Realiza ingresso em turma.
     *
     * @param IngressarTurmaRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(IngressarTurmaRequest $request): RedirectResponse
    {
        $this->turmaRepository->ingressarAluno($request->get('codigo'));
        return redirect()->route('turmas.ingresso.index')->with('success', 'Ingresso realizado com sucesso!');
    }
}
