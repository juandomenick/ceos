<?php

namespace App\Http\Requests\Academico\Atividades\Designar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AtualizarAtividadeDesignadaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('professor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'turma_id' => ['required_without_all:equipe_id,aluno_id', 'integer', 'exists:turmas,id'],
            'equipe_id' => ['required_without_all:turma_id,aluno_id', 'integer', 'exists:equipes,id'],
            'aluno_id' => ['required_without_all:turma_id,equipe_id', 'integer', 'exists:alunos,id'],
            'pontos' => ['required', 'integer', 'min:0'],
            'tempo' => ['required', 'integer', 'min:0'],
            'descricao' => ['required', 'string', 'max:65535'],
            'ativo' => ['required', 'boolean'],
        ];
    }
}
