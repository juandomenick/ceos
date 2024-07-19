<?php

namespace App\Http\Controllers\Dashboard\Academico\Cursos;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Cursos\AtualizarCursoRequest;
use App\Http\Requests\Academico\Cursos\CadastrarCursoRequest;
use App\Services\Academico\Interfaces\CursoServiceInterface;
use App\Services\Academico\Interfaces\InstituicaoServiceInterface;
use App\Services\Usuarios\Interfaces\CoordenadorServiceInterface;
use App\Services\Usuarios\Interfaces\ProfessorServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CursoController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Cursos
 */
class CursoController extends Controller
{
    /**
     * @var CursoServiceInterface
     */
    private $cursoService;
    /**
     * @var CoordenadorServiceInterface
     */
    private $coordenadorService;
    /**
     * @var InstituicaoServiceInterface
     */
    private $instituicaoService;
    /**
     * @var ProfessorServiceInterface
     */
    private $professorService;

    /**
     * CursoController constructor.
     *
     * @param CursoServiceInterface $cursoService
     * @param CoordenadorServiceInterface $coordenadorService
     * @param InstituicaoServiceInterface $instituicaoService
     * @param ProfessorServiceInterface $professorService
     */
    public function __construct(
        CursoServiceInterface $cursoService,
        CoordenadorServiceInterface $coordenadorService,
        InstituicaoServiceInterface $instituicaoService,
        ProfessorServiceInterface $professorService
    )
    {
        $this->middleware('role:administrador|diretor')->except(['index', 'show', 'edit', 'update']);
        $this->middleware('role:administrador|diretor|coordenador|professor')
            ->only(['index', 'show', 'edit', 'update']);

        $this->cursoService = $cursoService;
        $this->coordenadorService = $coordenadorService;
        $this->instituicaoService = $instituicaoService;
        $this->professorService = $professorService;
    }

    /**
     * Lista todas os Cursos.
     *
     * @return View
     */
    public function index(): View
    {
        $cursos = $this->cursoService->listarTodos();
        return view('dashboard.academico.cursos.index', compact('cursos'));
    }

    /**
     * Exibe o formulário de cadastro de Curso.
     *
     * @return View
     */
    public function create(): View
    {
        $instituicoes = $this->instituicaoService->listarTodos();
        $coordenadores = json_encode($this->coordenadorService->listarTodos());
        $professores = $this->professorService->listarTodos();

        return view('dashboard.academico.cursos.create', compact('instituicoes', 'coordenadores', 'professores'));
    }

    /**
     * Armazena um novo Curso no banco de dados.
     *
     * @param CadastrarCursoRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarCursoRequest $request): RedirectResponse
    {
        try {
            $this->cursoService->cadastrar((object) $request->all());
            return redirect()->route('cursos.index')->with('success', 'Curso cadastrado com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe um Curso específico.
     *
     * @param int $id
     * @return Model
     */
    public function show(int $id): Model
    {
        return $this->cursoService->buscarPorId($id);
    }

    /**
     * Exibe o formulário de edição do Curso.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $curso = $this->cursoService->buscarPorId($id);
        $coordenadores = $this->coordenadorService->listarTodos();
        $professores = $this->professorService->listarTodos();

        return view('dashboard.academico.cursos.edit', compact('curso', 'coordenadores', 'professores'));
    }

    /**
     *  Atualiza um Curso no banco de dados.
     *
     * @param AtualizarCursoRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarCursoRequest $request, int $id): RedirectResponse
    {
        try {
            $curso = $this->cursoService->atualizar((object) $request->all(), $id);
            return redirect()->route('cursos.edit', $curso->id)->with('success', 'Curso atualizado com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove um Curso do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $this->cursoService->deletar($id);
            $request->session()->flash('success', 'Curso deletado com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
