<?php

namespace App\Http\Controllers\Dashboard\Academico\Competencias;

use App\DataTables\Academico\CompetenciasDataTable;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academico\Competencias\AtualizarCompetenciaRequest;
use App\Http\Requests\Academico\Competencias\CadastrarCompetenciaRequest;
use App\Repositories\Interfaces\Academico\CompetenciaRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CompetenciaController
 *
 * @package App\Http\Controllers\Dashboard\Academico\Competencias
 */
class CompetenciaController extends Controller
{
    /**
     * @var CompetenciaRepository
     */
    private $competenciaRepository;

    /**
     * CompetenciaController constructor.
     *
     * @param CompetenciaRepository $competenciaRepository
     */
    public function __construct(CompetenciaRepository $competenciaRepository)
    {
        $this->middleware(['auth', 'role:administrador|diretor|coordenador|professor']);
        $this->competenciaRepository = $competenciaRepository;
    }

    /**
     * Lista todas as Competências.
     *
     * @param CompetenciasDataTable $competenciasDataTable
     * @return mixed
     */
    public function index(CompetenciasDataTable $competenciasDataTable)
    {
        return $competenciasDataTable->render('dashboard.academico.competencias.index');
    }

    /**
     * Exibe o formulário de cadastro de Competência.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.academico.competencias.create');
    }

    /**
     * Armazena nova Competência no banco de dados.
     *
     * @param CadastrarCompetenciaRequest $request
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function store(CadastrarCompetenciaRequest $request): RedirectResponse
    {
        try {
            $this->competenciaRepository->create($request->all());
            return redirect()->route('competencias.index')->with('success', 'Competência cadastrada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Exibe o formulário de edição de competência.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $competencia = $this->competenciaRepository->find($id);
        return view('dashboard.academico.competencias.edit', compact('competencia'));
    }

    /**
     * Atualiza uma Competência no banco de dados.
     *
     * @param AtualizarCompetenciaRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws TransactionException
     */
    public function update(AtualizarCompetenciaRequest $request, int $id): RedirectResponse
    {
        try {
            $this->competenciaRepository->update($request->all(), $id);
            return redirect()->route('competencias.edit', $id)->with('success', 'Competência atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }

    /**
     * Remove uma Competência do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->competenciaRepository->delete($id);
            $request->session()->flash('success', 'Competência deletada com sucesso!');

            return response(Response::HTTP_OK);
        } catch (Exception $exception) {
            throw new TransactionException($exception->getMessage());
        }
    }
}
