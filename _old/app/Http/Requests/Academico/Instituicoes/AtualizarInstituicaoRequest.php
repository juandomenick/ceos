<?php

namespace App\Http\Requests\Academico\Instituicoes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AtualizarInstituicaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador|diretor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => ['required', 'string'],
            'sigla' => ['required', 'string'],
            'telefone' => ['required', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'cidades' => ['required', 'integer', 'exists:cidades,id'],
            'diretor' => [Rule::requiredIf(Auth::user()->hasRole('administrador')), 'integer', 'exists:users,id'],
        ];
    }
}
