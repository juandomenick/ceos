<?php

namespace App\Http\Requests\Academico\Cursos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class CadastrarCursoRequest
 *
 * @package App\Http\Requests\Academico\Cursos
 */
class CadastrarCursoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador|diretor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tipoCoordenador = $this->request->get('tipo-cadastro');
        $requiredNovoCoordenador = $tipoCoordenador === 'novo-coordenador' ? 'required' : 'nullable';
        $requiredSelecionarCoordenador = $tipoCoordenador === 'selecionar-coordenador' ? 'required' : 'nullable';

        return [
            'nome' => ['required', 'string'],
            'sigla' => ['required', 'string'],
            'nivel' => ['required', 'string', Rule::in(['Infantil', 'Fundamental', 'Médio', 'Técnico', 'Graduação', 'Pós-Graduação'])],
            'instituicao' => ['required', 'integer', 'exists:instituicoes,id'],
            'coordenador_id' => [$requiredSelecionarCoordenador, 'integer', 'exists:coordenadores,id'],
            'coordenador.nome' => [$requiredNovoCoordenador, 'string'],
            'coordenador.celular' => [$requiredNovoCoordenador, 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'coordenador.telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'coordenador.email' => [$requiredNovoCoordenador, 'string', 'email', 'unique:users,email'],
            'coordenador.usuario' => [$requiredNovoCoordenador, 'string', 'max:20', 'unique:users,usuario'],
            'coordenador.password' => [$requiredNovoCoordenador, 'string', 'min:8', 'confirmed'],
            'coordenador.password_confirmation' => [$requiredNovoCoordenador, 'string', 'min:8'],
            'professores' => ['nullable', 'array']
        ];
    }
}
