<?php

namespace App\Http\Controllers\Dashboard\Usuarios\Professores;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\Professor\AtualizarProfessorRequest;
use App\Http\Requests\Usuarios\Professor\CadastrarProfessorRequest;
use App\Services\Usuarios\Interfaces\ProfessorServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Class ProfessorController
 *
 * @package App\Http\Controllers\Dashboard\usuarios\Professores
 */
class ProfessorController extends Controller
{
    /**
     * @var ProfessorServiceInterface
     */
    private $professorService;

    /**
     * ProfessorController constructor.
     *
     * @param ProfessorServiceInterface $professorService
     */
    public function __construct(ProfessorServiceInterface $professorService)
    {
        $this->professorService = $professorService;
    }

    /**
     * Lista todos os Professores.
     *
     * @return View
     */
    public function index(): View
    {
        $professores = $this->professorService->listarTodos();
        return view('dashboard.usuarios.professores.index', compact('professores'));
    }

    /**
     * Exibe o formulário de cadastro de Professor.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.usuarios.professores.create');
    }

    /**
     * Armazena um novo Professor no banco de dados.
     *
     * @param CadastrarProfessorRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarProfessorRequest $request): RedirectResponse
    {
        try {
            $usuario = $this->professorService->cadastrar((object) $request->all());
            $this->professorService->enviarVerificacao($usuario);

            return redirect()
                ->route('professores.index')
                ->with('success', 'Professor cadastrado com sucesso! Uma mensagem de verificação foi enviada por e-mail.');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     *  Exibe o formulário de edição do Professor.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $professor = $this->professorService->buscarPorId($id);
        return view('dashboard.usuarios.professores.edit', compact('professor'));
    }

    /**
     * Atualiza um Professor no banco de dados.
     *
     * @param AtualizarProfessorRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarProfessorRequest $request, int $id): RedirectResponse
    {
        try {
            $this->professorService->atualizar((object) $request->all(), $id);
            return redirect()->route('professores.edit', $id)->with('success', 'Professor editado com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove um Professor do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $this->professorService->deletar($id);
            $request->session()->flash('success', 'Professor deletado com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            throw new TransactionException($exception->getMessage());
        }
    }
}
