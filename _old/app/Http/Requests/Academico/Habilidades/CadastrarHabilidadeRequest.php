<?php

namespace App\Http\Requests\Academico\Habilidades;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class CadastrarHabilidadeRequest
 * @package App\Http\Requests\Academico\Habilidades
 */
class CadastrarHabilidadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador|diretor|coordenador|professor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descricao' => ['required', 'string', 'max:250'],
            'sigla' => ['required', 'string', 'max:10'],
            'nivel' => ['required', 'string', Rule::in(['Fácil', 'Intermediário', 'Difícil'])],
            'competencia_id' => ['required', 'integer', 'exists:competencias,id']
        ];
    }
}
