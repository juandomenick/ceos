<?php

namespace App\Http\Requests\Academico\Questoes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class QuestaoUpdateRequest
 *
 * @package App\Http\Requests\Academico
 */
class AtualizarQuestaoRequest extends FormRequest
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
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'pontos' => ['required', 'integer'],
            'tempo_minimo' => ['required', 'integer'],
            'tempo_maximo' => ['required', 'integer'],
            'ativo' => ['required', 'boolean'],
            'nivel' => ['required', 'string', Rule::in(['Fácil', 'Intermediário', 'Difícil'])],
            'tipo' => ['required', 'string', Rule::in(['Alternativa', 'Complete', 'Dissertativa', 'Ordenação', 'Quizz', 'Sócio Econômico'])],
            'professor_id' => ['required', 'integer', 'exists:professores,id'],
            'habilidade_id' => ['required', 'integer', 'exists:habilidades,id'],
        ];
    }
}
