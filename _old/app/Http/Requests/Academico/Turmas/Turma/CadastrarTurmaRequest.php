<?php

namespace App\Http\Requests\Academico\Turmas\Turma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CadastrarTurmaRequest
 *
 * @package App\Http\Requests\Academico\Turmas
 */
class CadastrarTurmaRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:50'],
            'sigla' => ['required', 'string', 'max:10'],
            'ano' => ['required', 'integer', 'date_format:Y'],
            'semestre' => ['required', 'integer'],
            'disciplina_id' => ['required', 'integer', 'exists:disciplinas,id'],
            'professor_id' => ['required', 'integer', 'exists:professores,id']
        ];
    }
}
