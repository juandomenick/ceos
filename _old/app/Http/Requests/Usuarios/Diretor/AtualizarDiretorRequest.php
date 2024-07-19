<?php

namespace App\Http\Requests\Usuarios\Diretor;

use App\Services\Usuarios\Interfaces\UsuarioServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AtualizarDiretorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param UsuarioServiceInterface $usuarioService
     * @return array
     */
    public function rules(UsuarioServiceInterface $usuarioService)
    {
        $user = $usuarioService->buscar([['email', $this->request->get('email')]])->first();

        return [
            'nome' => ['required', 'string'],
            'celular' => ['required', 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'usuario' => ['required', 'string', 'max:20', Rule::unique('users', 'usuario')->ignore($user->id)]
        ];
    }
}
