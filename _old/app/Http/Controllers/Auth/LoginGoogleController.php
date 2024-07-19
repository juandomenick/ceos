<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Usuarios\Interfaces\UsuarioRepositoryInterface;
use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use App\Services\Usuarios\UsuarioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginGoogleController extends Controller
{
    /**
     * @var UsuarioRepositoryInterface
     */
    private $usuarioRepository;
    /**
     * @var UsuarioService
     */
    private $usuarioService;

    /**
     * Create a new controller instance.
     *
     * @param UsuarioRepositoryInterface $usuarioRepository
     * @param UsuarioServiceInterface $usuarioService
     */
    public function __construct(UsuarioRepositoryInterface $usuarioRepository, UsuarioServiceInterface $usuarioService)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->usuarioService = $usuarioService;
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(config('services.google.scopes'))
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return RedirectResponse
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        $usuarioGoogle = Socialite::driver('google')->stateless()->user();

        $usuario = $this->usuarioRepository->buscar(
            [['google_id', '=', $usuarioGoogle->id]],
            [['email', '=', $usuarioGoogle->email]]
        )->first();

        if ($usuario) {
            if (!$usuario->google_id) {
                $usuario->google_id = $usuarioGoogle->id;
                $usuario->avatar = $usuarioGoogle->avatar;
                $this->usuarioService->atualizar($usuario, $usuario->id);
            }

            if (Auth::check()) {
                return redirect()->route('perfil.editar')->with('error', 'A conta selecionada já se econtrola vinculada a outro usuário');
            } else {
                Auth::login($usuario);
                Session::put('tokenGoogle', $usuarioGoogle->token);

                return redirect()->route('home');
            }
        } else {
            if (Auth::check()) {
                $usuario = Auth::user();
                $usuario->google_id = $usuarioGoogle->id;
                $usuario->avatar = $usuarioGoogle->avatar;
                $this->usuarioService->atualizar($usuario, $usuario->id);

                return redirect()->route('perfil.editar')->with('success', 'Conta vinculada com sucesso!');;
            } else {
                $usuario = (array) $usuarioGoogle;
                return redirect()->route('register')->with('usuario', $usuario);
            }
        }
    }
}
