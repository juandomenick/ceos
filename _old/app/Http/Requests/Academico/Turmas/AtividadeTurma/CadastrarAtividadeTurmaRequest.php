<?php

namespace App\Http\Requests\Academico\Turmas\AtividadeTurma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CadastrarAtividadeTurmaRequest
 *
 * @package App\Http\Requests\Academico\Turmas\AtividadeTurma
 */
class CadastrarAtividadeTurmaRequest extends FormRequest
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
            'professor_id' => ['required', 'integer', 'exists:professores,id'],
            'turma_id' => ['required', 'integer'],
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:65000'],
            'pontos' => ['required', 'integer', 'min:1'],
            'data_entrega' => ['required'],
        ];
    }
}
