<?php

namespace App\Http\Requests\Academico\Turmas\Turma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class AtualizarTurmaRequest
 *
 * @package App\Http\Requests\Academico\Turmas
 */
class AtualizarTurmaRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:50'],
            'sigla' => ['required', 'string', 'max:10'],
            'ano' => ['nullable', 'integer', 'date_format:Y'],
            'semestre' => ['nullable', 'integer'],
            'disciplina_id' => ['nullable', 'integer', 'exists:disciplinas,id'],
            'professor_id' => ['nullable', 'integer', 'exists:professores,id'],
            'ativo' => ['nullable'],
            'alunos' => ['nullable', 'array']
        ];
    }
}
