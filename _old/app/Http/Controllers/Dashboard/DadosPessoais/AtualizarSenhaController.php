<?php

namespace App\Http\Controllers\Dashboard\DadosPessoais;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\AtualizarSenhaRequest;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AtualizarSenhaController extends Controller
{
    private $usuarioService;

    public function __construct(UsuarioServiceInterface $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function edit(): View
    {
        return view('dashboard.dados-pessois.senha');
    }

    public function update(AtualizarSenhaRequest $request, $id): RedirectResponse
    {
        try {
            $this->usuarioService->atualizarSenha((object) $request->all(), $id);
            return redirect()->route('senha.editar')->with('success', 'Senha atualizada com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException('Erro ao atualizar perfil. Código do erro: ' . $exception->getCode());
        }

    }
}
