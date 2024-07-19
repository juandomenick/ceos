<?php

namespace App\Http\Requests\Usuarios;

use App\Rules\Usuarios\VerificarSenhaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AtualizarSenhaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'senha_atual' => ['required', 'string', new VerificarSenhaRule()],
            'nova_senha' => ['required', 'string', 'min:8', 'confirmed']
        ];
    }
}
