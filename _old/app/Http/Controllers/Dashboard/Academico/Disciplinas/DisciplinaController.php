<?php

namespace App\Http\Controllers\Dashboard\Academico\Disciplinas;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Disciplinas\AtualizarDisciplinaRequest;
use App\Http\Requests\Academico\Disciplinas\CadastrarDisciplinaRequest;
use App\Services\Academico\Interfaces\CursoServiceInterface;
use App\Services\Academico\Interfaces\DisciplinaServiceInterface;
use App\Services\Academico\Interfaces\InstituicaoServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DisciplinaController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Disciplinas
 */
class DisciplinaController extends Controller
{
    /**
     * @var DisciplinaServiceInterface
     */
    private $disciplinaService;
    /**
     * @var InstituicaoServiceInterface
     */
    private $instituicaoService;
    /**
     * @var CursoServiceInterface
     */
    private $cursoService;

    /**
     * DisciplinaController constructor.
     *
     * @param DisciplinaServiceInterface $disciplinaService
     * @param InstituicaoServiceInterface $instituicaoService
     * @param CursoServiceInterface $cursoService
     */
    public function __construct(
        DisciplinaServiceInterface $disciplinaService,
        InstituicaoServiceInterface $instituicaoService,
        CursoServiceInterface $cursoService
    )
    {
        $this->middleware(['role:administrador|diretor|coordenador'])->except(['index', 'show', 'edit', 'update']);
        $this->middleware(['role:administrador|diretor|coordenador|professor'])->only(['index', 'show', 'edit', 'update']);

        $this->disciplinaService = $disciplinaService;
        $this->instituicaoService = $instituicaoService;
        $this->cursoService = $cursoService;
    }

    /**
     * Lista todas as Disciplinas.
     *
     * @return View
     */
    public function index(): View
    {
        $disciplinas = $this->disciplinaService->listarTodos();
        return view('dashboard.academico.disciplinas.index', compact('disciplinas'));
    }

    /**
     * Exibe o formulário de cadastro de Disciplina.
     *
     * @return View
     */
    public function create(): View
    {
        $instituicoes = $this->instituicaoService->listarTodos();
        $cursos = $this->cursoService->listarTodos();

        return view('dashboard.academico.disciplinas.create', compact('instituicoes', 'cursos'));
    }

    /**
     * Armazena uma nova Disciplina no banco de dados.
     *
     * @param CadastrarDisciplinaRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarDisciplinaRequest $request): RedirectResponse
    {
        try {
            $this->disciplinaService->cadastrar((object) $request->all());
            return redirect()->route('disciplinas.index')->with( 'success', 'Disciplina cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe uma Disciplina específica.
     *
     * @param int $id
     * @return Model
     */
    public function show(int $id): Model
    {
        return $this->disciplinaService->buscarPorId($id);
    }

    /**
     * Exibe o formulário de edição da Disciplina.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $disciplina = $this->disciplinaService->buscarPorId($id);
        $instituicoes = $this->instituicaoService->listarTodos();
        $cursos = $this->cursoService->listarTodos();

        return view('dashboard.academico.disciplinas.edit', compact('disciplina', 'instituicoes', 'cursos'));
    }

    /**
     * Atualiza uma Disciplina no banco de dados.
     *
     * @param AtualizarDisciplinaRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarDisciplinaRequest $request, int $id): RedirectResponse
    {
        try {
            $this->disciplinaService->atualizar((object) $request->all(), $id);
            return redirect()->route('disciplinas.edit', $id)->with('success', 'Disciplina atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Disciplina do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $this->disciplinaService->deletar($id);
            $request->session()->flash('success', 'Disciplina deletada com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
