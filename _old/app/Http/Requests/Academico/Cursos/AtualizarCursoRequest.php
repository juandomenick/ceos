<?php

namespace App\Http\Requests\Academico\Cursos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class AtualizarCursoRequest
 *
 * @package App\Http\Requests\Academico\Cursos
 */
class AtualizarCursoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador|diretor|coordenador');
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
            'nivel' => ['required', 'string', Rule::in(['Infantil', 'Fundamental', 'Médio', 'Técnico', 'Graduação', 'Pós-Graduação'])],
            'coordenador_id' => [Rule::requiredIf(Auth::user()->hasRole('administrador|diretor')), 'integer', 'exists:coordenadores,id'],
            'professores' => ['nullable', 'array']
        ];
    }
}
