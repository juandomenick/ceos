<?php

namespace App\Http\Requests\MinhasAtividades;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class ResponderAtividadeRequest
 *
 * @package App\Http\Requests\MinhasAtividades
 */
class ResponderAtividadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('aluno');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'atividade_id' => ['required', 'integer', 'exists:atividades_designadas,id'],
            'aluno_id' => ['required', 'integer', 'exists:alunos,id'],
            'questoes' => ['required', 'array'],
            'questoes.*' =>  ['required', 'string', 'max:255']
        ];
    }
}
