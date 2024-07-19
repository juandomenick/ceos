<?php

namespace App\Http\Controllers\Dashboard\Usuarios\Diretores;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\Diretor\AtualizarDiretorRequest;
use App\Http\Requests\Usuarios\Diretor\CadastrarDiretorRequest;
use App\Services\Usuarios\Interfaces\DiretorServiceInterface;
use App\Services\Usuarios\Interfaces\ProfessorServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class DiretorController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Diretores
 */
class DiretorController extends Controller
{
    /**
     * @var DiretorServiceInterface
     */
    private $diretorService;
    /**
     * @var ProfessorServiceInterface
     */
    private $professorService;

    /**
     * DiretorController constructor.
     *
     * @param DiretorServiceInterface $diretorService
     * @param ProfessorServiceInterface $professorService
     */
    public function __construct(DiretorServiceInterface $diretorService, ProfessorServiceInterface $professorService)
    {
        $this->diretorService = $diretorService;
        $this->professorService = $professorService;
    }

    /**
     * Lista todos os diretores.
     *
     * @return View
     */
    public function index(): View
    {
        $diretores = $this->diretorService->listarTodos();
        return view('dashboard.usuarios.diretores.index', compact('diretores'));
    }

    /**
     * Exibe o formulário de cadastro de Diretor.
     *
     * @return View
     */
    public function create(): View
    {
        $professores = $this->professorService->listarTodos();
        return view('dashboard.usuarios.diretores.create', compact('professores'));
    }

    /**
     * Armazena um novo Diretor no banco de dados.
     *
     * @param CadastrarDiretorRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarDiretorRequest $request): RedirectResponse
    {
        try {
            $this->diretorService->cadastrar((object) $request->all());

            $mensagem = $request->has('professor') ?
                'Professor promovido com sucesso' :
                'Diretor cadastrado com sucesso! Uma mensagem de verificação foi enviada por e-mail.';

            return redirect()->route('diretores.index')->with('success', $mensagem);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição do Diretor.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $diretor = $this->diretorService->buscarPorId($id);
        return view('dashboard.usuarios.diretores.edit', compact('diretor'));
    }

    /**
     * Atualiza um Diretor no banco de dados.
     *
     * @param AtualizarDiretorRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarDiretorRequest $request, int $id): RedirectResponse
    {
        try {
            $this->diretorService->atualizar((object) $request->all(), $id);
            return redirect()->route('diretores.edit', $id)->with('success', 'Diretor editado com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove um Diretor do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->diretorService->deletar($id);
            $request->session()->flash('success', 'Diretor deletado com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
