<?php

namespace App\Http\Requests\Academico\Turmas\IngressoTurma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class IngressarTurmaRequest
 *
 * @package App\Http\Requests\Academico\Turmas\IngressoTurma
 */
class IngressarTurmaRequest extends FormRequest
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
            'codigo' => ['required', 'string', 'exists:turmas,codigo_acesso'],
        ];
    }
}
