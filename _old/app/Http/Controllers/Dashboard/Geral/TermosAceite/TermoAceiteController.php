<?php

namespace App\Http\Controllers\Dashboard\Geral\TermosAceite;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Geral\TermosAceite\AtualizarTermoRequest;
use App\Http\Requests\Geral\TermosAceite\CadastrarTermoRequest;
use App\Services\Geral\Interfaces\TermoAceiteServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class TermoAceiteController extends Controller
{
    private $termoAceiteService;

    public function __construct(TermoAceiteServiceInterface $termoAceiteService)
    {
        $this->termoAceiteService = $termoAceiteService;
    }

    /**
     * Lista todos os Termos.
     *
     * @return View
     */
    public function index(): View
    {
        $termos = $this->termoAceiteService->listarTodos();
        return view('dashboard.geral.termos-aceite.index', compact('termos'));
    }

    /**
     * Exibe o formulário de cadastro de Termo.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.geral.termos-aceite.create');
    }

    /**
     * Armazena um novo Termo no banco de dados.
     *
     * @param CadastrarTermoRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CadastrarTermoRequest $request): RedirectResponse
    {
        try {
            $this->termoAceiteService->cadastrar((object) $request->all());
            return redirect()->route('termos-aceite.index')->with('success', 'Termo de aceite cadastrado com sucesso!');
        } catch (Exception $exception) {
            throw new  TransactionException('Erro ao cadastrar termo de aceite.');
        }
    }

    /**
     * Exibe um Termo a partir do seu ID.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $termo = $this->termoAceiteService->buscarPorId($id);
        return view('dashboard.geral.termos-aceite.show', compact('termo'));
    }

    /**
     * Exibe o formulário de edição do Termo.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $termo = $this->termoAceiteService->buscarPorId($id);
        return view('dashboard.geral.termos-aceite.edit', compact('termo'));
    }

    /**
     * Atualiza um Termo no banco de dados.
     *
     * @param AtualizarTermoRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(AtualizarTermoRequest $request, int $id): RedirectResponse
    {
        try {
            $termo = $this->termoAceiteService->atualizar((object) $request->all(), $id);
            return redirect()->route('termos-aceite.edit', $termo->id)->with('success', 'Termo de aceite editado com sucesso!');
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            throw new TransactionException('Erro ao editar termo de aceite.');
        }
    }

    /**
     * Remove um Termo do banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws TransactionException
     */
    public function destroy(Request $request, int $id): Response
    {
        try {
            $this->termoAceiteService->deletar($id);
            $request->session()->flash('success', 'Termo de aceite deletado com sucesso!');

            return response(Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            throw new TransactionException('Erro ao deletar termo de aceite.');
        }
    }
}
