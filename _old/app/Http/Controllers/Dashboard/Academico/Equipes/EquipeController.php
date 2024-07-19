<?php

namespace App\Http\Controllers\Dashboard\Academico\Equipes;

use App\Criteria\Academico\Equipes\EquipeCriteria;
use App\DataTables\Academico\EquipesDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Equipes\AtualizarEquipeRequest;
use App\Http\Requests\Academico\Equipes\CadastrarEquipeRequest;
use App\Repositories\Interfaces\Academico\EquipeRepository;
use App\Repositories\Interfaces\Academico\Turmas\TurmaRepository;
use App\Repositories\Interfaces\Usuarios\AlunoRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EquipeController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Equipes
 */
class EquipeController extends Controller
{
    /**
     * @var EquipeRepository
     */
    private $equipeRepository;

    /**
     * @var TurmaRepository
     */
    private $turmaRepository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * EquipeController constructor.
     *
     * @param EquipeRepository $equipeRepository
     * @param TurmaRepository $turmaRepository
     * @param AlunoRepository $alunoRepository
     */
    public function __construct(
        EquipeRepository $equipeRepository,
        TurmaRepository $turmaRepository,
        AlunoRepository $alunoRepository
    )
    {
        $this->middleware(['role:administrador|diretor|coordenador|professor']);

        $this->equipeRepository = $equipeRepository;
        $this->turmaRepository = $turmaRepository;
        $this->alunoRepository = $alunoRepository;

        $this->equipeRepository->pushCriteria(new EquipeCriteria());
    }

    /**
     * Lista todas as Equipes.
     *
     * @param EquipesDataTable $equipesDataTable
     * @return mixed
     */
    public function index(EquipesDataTable $equipesDataTable)
    {
        return $equipesDataTable->render('dashboard.academico.equipes.index');
    }

    /**
     * Exibe formulário de cadastro de Equipe.
     *
     * @return View
     */
    public function create(): View
    {
        $turmas = $this->turmaRepository->scopeQuery(function ($query) {
            return $query;
        })->pluck('nome', 'id');
        $alunos = $this->alunoRepository->all()->pluck('user.nome', 'id');

        return view('dashboard.academico.equipes.create', compact('turmas', 'alunos'));
    }

    /**
     * Armazena uma nova Equipe no banco de dados.
     *
     * @param CadastrarEquipeRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarEquipeRequest $request): RedirectResponse
    {
        try {
            $this->equipeRepository->create($request->all());
            return redirect()->route('equipes.index')->with('success', 'Equipe cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }


    /**
     * Exibe formulário de edição de Equipe.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $equipe = $this->equipeRepository->find($id);
        $turmas = $this->turmaRepository->scopeQuery(function ($query) {
            return $query;
        })->pluck('nome', 'id');
        $alunos = $this->alunoRepository->all()->pluck('user.nome', 'id');

        return view('dashboard.academico.equipes.edit', compact('equipe', 'turmas', 'alunos'));
    }

    /**
     * Atualizar uma Equipe no banco de dados.
     *
     * @param AtualizarEquipeRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarEquipeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->equipeRepository->update($request->all(), $id);
            return redirect()->route('equipes.edit', $id)->with('success', 'Equipe atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Equipe do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->equipeRepository->delete($id);
            $request->session()->flash('success', 'Equipe deletada com sucesso!');

            return response(Response::HTTP_OK);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
