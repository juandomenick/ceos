<?php

namespace App\Http\Requests\Academico\AnotacoesAula;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CadastrarAnotacaoAulaRequest
 *
 * @package App\Http\Requests\Academico\AnotacoesAula
 */
class CadastrarAnotacaoAulaRequest extends FormRequest
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
            'turma_id' => ['required', 'integer', 'exists:turmas,id'],
            'aluno' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:255'],
            'data' => ['required', 'date'],
            'hora' => ['required', 'date_format:H:i'],
            'assinatura' => ['required', 'string', 'max:255'],
        ];
    }
}
