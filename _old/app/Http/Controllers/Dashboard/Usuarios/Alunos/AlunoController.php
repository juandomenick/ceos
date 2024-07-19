<?php

namespace App\Http\Controllers\Dashboard\Usuarios\Alunos;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\Aluno\AtualizarAlunoRequest;
use App\Http\Requests\Usuarios\Aluno\CadastrarAlunoRequest;
use App\Services\Usuarios\Interfaces\AlunoServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AlunoController
 *
 * @package App\Http\Controllers\Dashboard\usuarios\Alunos
 */
class AlunoController extends Controller
{
    /**
     * @var AlunoServiceInterface
     */
    private $alunoService;

    /**
     * AlunoController constructor.
     *
     * @param AlunoServiceInterface $alunoService
     */
    public function __construct(AlunoServiceInterface $alunoService)
    {
        $this->alunoService = $alunoService;
    }

    /**
     * Lista todos os Alunos.
     *
     * @return View
     */
    public function index(): View
    {
        $alunos = $this->alunoService->listarTodos();
        return view('dashboard.usuarios.alunos.index', compact('alunos'));
    }

    /**
     * Exibe o formulário de cadastro de Aluno.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.usuarios.alunos.create');
    }

    /**
     * Armazena um novo Aluno no banco de dados.
     *
     * @param CadastrarAlunoRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarAlunoRequest $request): RedirectResponse
    {
        try {
            $usuario = $this->alunoService->cadastrar((object) $request->all());
            $this->alunoService->enviarVerificacao($usuario);

            return redirect()
                ->route('alunos.index')
                ->with('success', 'Aluno cadastrado com sucesso! Uma mensagem de verificação foi enviada por e-mail.');
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição do Aluno.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $aluno = $this->alunoService->buscarPorId($id);
        return view('dashboard.usuarios.alunos.edit', compact('aluno'));
    }

    /**
     * Atualiza um Aluno no banco de dados.
     *
     * @param AtualizarAlunoRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarAlunoRequest $request, $id): RedirectResponse
    {
        try {
            $this->alunoService->atualizar((object) $request->all(), $id);
            return redirect()->route('alunos.edit', $id)->with('success', 'Aluno editado com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove um Aluno do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, $id): Response
    {
        try {
            $this->alunoService->deletar($id);
            $request->session()->flash('success', 'Aluno deletado com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
