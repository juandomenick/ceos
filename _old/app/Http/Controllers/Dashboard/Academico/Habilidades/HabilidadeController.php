<?php

namespace App\Http\Controllers\Dashboard\Academico\Habilidades;

use App\DataTables\Academico\HabilidadesDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Habilidades\AtualizarHabilidadeRequest;
use App\Http\Requests\Academico\Habilidades\CadastrarHabilidadeRequest;
use App\Repositories\Interfaces\Academico\CompetenciaRepository;
use App\Repositories\Interfaces\Academico\HabilidadeRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HabilidadeController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Habilidades
 */
class HabilidadeController extends Controller
{
    /**
     * @var HabilidadeRepository
     */
    private $habilidadeRepository;

    /**
     * @var CompetenciaRepository
     */
    private $competenciaRepository;

    /**
     * HabilidadeController constructor.
     *
     * @param HabilidadeRepository $habilidadeRepository
     * @param CompetenciaRepository $competenciaRepository
     */
    public function __construct(HabilidadeRepository $habilidadeRepository, CompetenciaRepository $competenciaRepository)
    {
        $this->middleware(['auth', 'role:administrador|diretor|coordenador|professor']);

        $this->habilidadeRepository = $habilidadeRepository;
        $this->competenciaRepository = $competenciaRepository;
    }

    /**
     * Lista todas as Habilidades.
     *
     * @param HabilidadesDataTable $habilidadesDataTable
     * @return mixed
     */
    public function index(HabilidadesDataTable $habilidadesDataTable)
    {
        return $habilidadesDataTable->render('dashboard.academico.habilidades.index');
    }

    /**
     * Exibe o formulário de cadastro de Habilidade.
     *
     * @return View
     */
    public function create(): View
    {
        $competencias = $this->competenciaRepository->all(['id', 'descricao'])->pluck('descricao', 'id');
        return view('dashboard.academico.habilidades.create', compact('competencias'));
    }

    /**
     * Armazena uma nova Habilidade no banco de dados.
     *
     * @param CadastrarHabilidadeRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarHabilidadeRequest $request): RedirectResponse
    {
        try {
            $this->habilidadeRepository->create($request->all());
            return redirect()->route('habilidades.index')->with('success', 'Habilidade cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição de Habilidade.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $habilidade = $this->habilidadeRepository->find($id);
        $competencias = $this->competenciaRepository->all(['id', 'descricao'])->pluck('descricao', 'id');

        return view('dashboard.academico.habilidades.edit', compact('habilidade', 'competencias'));
    }

    /**
     * Atualiza uma Habilidade no banco de dados.
     *
     * @param AtualizarHabilidadeRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarHabilidadeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->habilidadeRepository->update($request->all(), $id);
            return redirect()->route('habilidades.edit', $id)->with('success', 'Habilidade atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Habilidade do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->habilidadeRepository->delete($id);
            $request->session()->flash('success', 'Habilidade deletada com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
