<?php

namespace App\Http\Controllers\Dashboard\Academico\Instituicoes;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Instituicoes\AtualizarInstituicaoRequest;
use App\Http\Requests\Academico\Instituicoes\CadastrarInstituicaoRequest;
use App\Services\Academico\Interfaces\InstituicaoServiceInterface;
use App\Services\Usuarios\Interfaces\DiretorServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InstituicaoController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Instituicoes
 */
class InstituicaoController extends Controller
{
    /**
     * @var InstituicaoServiceInterface
     */
    private $instituicaoService;
    /**
     * @var DiretorServiceInterface
     */
    private $diretorService;

    /**
     * InstituicaoController constructor.
     *
     * @param InstituicaoServiceInterface $instituicaoService
     * @param DiretorServiceInterface $diretorService
     */
    public function __construct(
        InstituicaoServiceInterface $instituicaoService,
        DiretorServiceInterface $diretorService
    )
    {
        $this->middleware(['role:administrador'])->except(['index', 'show', 'edit', 'update']);
        $this->middleware(['role:administrador|diretor|coordenador|professor'])->only(['index', 'show', 'edit', 'update']);

        $this->instituicaoService = $instituicaoService;
        $this->diretorService = $diretorService;
    }

    /**
     * Lista todas as Instituições.
     *
     * @return View
     */
    public function index(): View
    {
        $instituicoes = $this->instituicaoService->listarTodos();
        return view('dashboard.academico.instituicoes.index', compact('instituicoes'));
    }

    /**
     * Exibe o formulário de cadastro de Instituição.
     *
     * @return View
     */
    public function create(): View
    {
        $diretores = $this->diretorService->listarTodos();
        return view('dashboard.academico.instituicoes.create', compact('diretores'));
    }

    /**
     * Armazena uma nova Instituição no banco de dados.
     *
     * @param CadastrarInstituicaoRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarInstituicaoRequest $request): RedirectResponse
    {
        try {
            $this->instituicaoService->cadastrar((object) $request->all());
            return redirect()
                ->route('instituicoes.index')
                ->with('success', 'Instituição cadastrada com sucesso! Uma mensagem de verificação foi enviada para o diretor por e-mail.');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe uma Instituição específica.
     *
     * @param int $id
     * @return Model
     */
    public function show(int $id): Model
    {
        return $this->instituicaoService->buscarPorId($id);
    }

    /**
     * Exibe o formulário de edição da Instituição.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $instituicao = $this->instituicaoService->buscarPorId($id);
        $diretores = $this->diretorService->listarTodos();

        return view('dashboard.academico.instituicoes.edit', compact('instituicao', 'diretores'));
    }

    /**
     *  Atualiza uma Instituição do banco de dados.
     *
     * @param AtualizarInstituicaoRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarInstituicaoRequest $request, int $id): RedirectResponse
    {
        try {
            $instituicao = $this->instituicaoService->atualizar((object) $request->all(), $id);
            return redirect()
                ->route('instituicoes.edit', $instituicao->id)
                ->with('success', 'Instituição atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Instituição do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $this->instituicaoService->deletar($id);
            $request->session()->flash('success', 'Instituição deletada com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
