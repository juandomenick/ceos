<?php

namespace App\Http\Requests\Academico\Questoes\Alternativas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CadastrarAlterntivaRequest
 *
 * @package App\Http\Requests\Academico\Questoes\Alternativas
 */
class CadastrarAlternativaRequest extends FormRequest
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
            'descricao' => ['required', 'string'],
            'alternativa_correta' => ['nullable', 'boolean']
        ];
    }
}
