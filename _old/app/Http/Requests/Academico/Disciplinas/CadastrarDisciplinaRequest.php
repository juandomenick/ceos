<?php

namespace App\Http\Requests\Academico\Disciplinas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CadastrarDisciplinaRequest
 *
 * @package App\Http\Requests\Academico\Disciplinas
 */
class CadastrarDisciplinaRequest extends FormRequest
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
            'curso_id' => ['required', 'integer', 'exists:cursos,id']
        ];
    }
}
