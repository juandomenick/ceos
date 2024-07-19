<?php

namespace App\Http\Controllers\Dashboard\Usuarios\Coordenadores;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\Coordenador\AtualizarCoordenadorRequest;
use App\Http\Requests\Usuarios\Coordenador\CadastrarCoordenadorRequest;
use App\Services\Academico\Interfaces\CursoServiceInterface;
use App\Services\Academico\Interfaces\InstituicaoServiceInterface;
use App\Services\Usuarios\Interfaces\CoordenadorServiceInterface;
use App\Services\Usuarios\Interfaces\ProfessorServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class CoordenadorController
 *
 * @package App\Http\Controllers\Dashboard\Usuarios\Coordenadores
 */
class CoordenadorController extends Controller
{
    /**
     * @var CoordenadorServiceInterface
     */
    private $coordenadorService;
    /**
     * @var ProfessorServiceInterface
     */
    private $professorService;
    /**
     * @var InstituicaoServiceInterface
     */
    private $instituicaoService;
    /**
     * @var CursoServiceInterface
     */
    private $cursoService;

    /**
     * CoordenadorController constructor.
     *
     * @param CoordenadorServiceInterface $coordenadorService
     * @param ProfessorServiceInterface $professorService
     * @param InstituicaoServiceInterface $instituicaoService
     * @param CursoServiceInterface $cursoService
     */
    public function __construct(
        CoordenadorServiceInterface $coordenadorService,
        ProfessorServiceInterface $professorService,
        InstituicaoServiceInterface $instituicaoService,
        CursoServiceInterface $cursoService
    )
    {
        $this->middleware(['role:administrador|diretor']);

        $this->coordenadorService = $coordenadorService;
        $this->professorService = $professorService;
        $this->instituicaoService = $instituicaoService;
        $this->cursoService = $cursoService;
    }

    /**
     * Lista todos os Coordenadores.
     *
     * @return View
     */
    public function index(): View
    {
        $coordenadores = $this->coordenadorService->listarTodos();
        return view('dashboard.usuarios.coordenadores.index', compact('coordenadores'));
    }

    /**
     * Exibe o formulário de cadastro de Coordenador.
     *
     * @return View
     */
    public function create(): View
    {
        $professores = $this->professorService->listarTodos();
        $instituicoes = $this->instituicaoService->listarTodos();

        return view('dashboard.usuarios.coordenadores.create', compact('professores', 'instituicoes'));
    }

    /**
     * Armazena um novo Coordenador no banco de dados.
     *
     * @param CadastrarCoordenadorRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarCoordenadorRequest $request): RedirectResponse
    {
        try {
            $this->coordenadorService->cadastrar((object) $request->all());

            $mensagem = $request->has('professor') ?
                'Professor promovido com sucesso!' :
                'Coordenador cadastrado com sucesso! Uma mensagem de verificação foi enviada por e-mail.';

            return redirect()->route('coordenadores.index')->with('success', $mensagem);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição do Coordenador.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $coordenador = $this->coordenadorService->buscarPorId($id);
        return view('dashboard.usuarios.coordenadores.edit', compact('coordenador'));
    }

    /**
     * Atualiza um Coordenador no banco de dados.
     *
     * @param AtualizarCoordenadorRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarCoordenadorRequest $request, int $id): RedirectResponse
    {
        try {
            $this->coordenadorService->atualizar((object) $request->all(), $id);
            return redirect()->route('coordenadores.edit', $id)->with('success', 'Coordenador editado com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove um Coordenador do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->coordenadorService->deletar($id);
            $request->session()->flash('success', 'Coordenador deletado com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
