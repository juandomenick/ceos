<?php

namespace App\Http\Controllers\Api\V1\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Resources\Usuarios\UsuarioResource;

/**
 * Class UsuarioController
 * @package App\Http\Controllers\Api\V1\Usuarios
 */
class UsuarioAutenticadoController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Retorna o usuário autenticado.
     *
     * @return UsuarioResource
     */
    public function __invoke(): UsuarioResource
    {
        return new UsuarioResource(auth()->user());
    }
}
