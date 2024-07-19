<?php

namespace App\Http\Requests\Academico\Atividades;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class CadastrarAtividadeRequest
 *
 * @package App\Http\Requests\Academico\Atividades
 */
class CadastrarAtividadeRequest extends FormRequest
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
            'disciplina_id' => ['required', 'integer', 'exists:disciplinas,id'],
            'tipo' => ['required', Rule::in(['Avaliação Impressa', 'Questionário', 'Simulado'])],
            'nivel' => ['required', Rule::in(['Iniciante', 'Inteligência Múltiplas', 'Sócio Econômico - Adulto', 'Sócio Ecoômico - Infantil'])],
            'visualizacao' => ['required', Rule::in(['Total', 'Individual'])],
            'pontos' => ['required', 'integer', 'min:1'],
            'tempo_minimo' => ['required', 'integer', 'min:1'],
            'tempo_maximo' => ['required', 'integer', 'min:1'],
            'metodo_avaliacao' => ['required', 'string'],
            'descricao' => ['required', 'string'],
            'questoes' => ['nullable', 'array'],
            'questoes.*' => ['required', 'integer', 'exists:questoes,id'],
            'ativo' => ['required', 'boolean']
        ];
    }
}
