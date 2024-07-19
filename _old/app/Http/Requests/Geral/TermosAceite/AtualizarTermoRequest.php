<?php

namespace App\Http\Requests\Geral\TermosAceite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AtualizarTermoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador|professor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => ['required', 'string'],
            'descricao' => ['required', 'string'],
            'ativo' => ['required', 'boolean']
        ];
    }
}
