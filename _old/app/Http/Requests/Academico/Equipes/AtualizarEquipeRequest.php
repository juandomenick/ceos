<?php

namespace App\Http\Requests\Academico\Equipes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class AtualizarEquipeRequest
 *
 * @package App\Http\Requests\Academico\Equipes
 */
class AtualizarEquipeRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:100'],
            'data_formacao' => ['required', 'date'],
            'ativo' => ['required', 'boolean'],
            'turma_id' => ['required', 'integer', 'exists:turmas,id'],
            'alunos' => ['nullable', 'array', 'exists:alunos,id']
        ];
    }
}
