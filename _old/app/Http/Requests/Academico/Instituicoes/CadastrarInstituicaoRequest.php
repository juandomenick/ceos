<?php

namespace App\Http\Requests\Academico\Instituicoes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CadastrarInstituicaoRequest
 *
 * @package App\Http\Requests\Academico\Instituicoes
 */
class CadastrarInstituicaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tipoDiretor = $this->request->get('tipo-cadastro');
        $requiredNovoDiretor = $tipoDiretor === 'novo-diretor' ? 'required' : 'nullable';
        $requiredSelecionarDiretor = $tipoDiretor === 'selecionar-diretor' ? 'required' : 'nullable';

        return [
            'nome' => ['required', 'string'],
            'sigla' => ['required', 'string'],
            'telefone' => ['required', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'cidades' => ['required', 'integer', 'exists:cidades,id'],
            'diretor_id' => [$requiredSelecionarDiretor, 'integer', 'exists:users,id'],
            'diretor.nome' => [$requiredNovoDiretor, 'string'],
            'diretor.celular' => [$requiredNovoDiretor, 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'diretor.telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'diretor.email' => [$requiredNovoDiretor, 'string', 'email', 'unique:users,email'],
            'diretor.usuario' => [$requiredNovoDiretor, 'string', 'max:20', 'unique:users,usuario'],
            'diretor.password' => [$requiredNovoDiretor, 'string', 'min:8', 'confirmed'],
            'diretor.password_confirmation' => [$requiredNovoDiretor, 'string', 'min:8']
        ];
    }
}
