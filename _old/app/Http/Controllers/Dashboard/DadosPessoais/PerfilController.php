<?php

namespace App\Http\Controllers\Dashboard\DadosPessoais;

use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\AtualizarUsuarioRequest;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PerfilController extends Controller
{
    private $usuarioService;

    public function __construct(UsuarioServiceInterface $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function edit(): View
    {
        return view('dashboard.dados-pessois.perfil');
    }

    public function update(AtualizarUsuarioRequest $request, int $id): RedirectResponse
    {
        try {
            
            $this->usuarioService->atualizar((object) $request->all(), $id);
            return redirect()->route('perfil.editar')->with('success', 'Perfil atualizado com sucesso!');
        } catch (Exception $exception) {
            throw new TransactionException('Erro ao atualizar perfil. Código do erro: ' . $exception->getCode());
        }
    }
}
