<?php

namespace App\Http\Requests\Usuarios\Coordenador;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CadastrarCoordenadorRequest extends FormRequest
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
        $tipoCadastro = $this->request->get('tipo-cadastro');

        $requiredIfNovoCoordenador = $tipoCadastro === 'novo-coordenador' ? 'required' : 'nullable';
        $requiredIfPromoverProfessor = $tipoCadastro === 'promover-professor' ? 'required' : 'nullable';

        return [
            'nome' => [$requiredIfNovoCoordenador, 'string'],
            'celular' => [$requiredIfNovoCoordenador, 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'email' => [$requiredIfNovoCoordenador, 'string', 'email', 'unique:users,email'],
            'usuario' => [$requiredIfNovoCoordenador, 'string', 'max:20', 'unique:users,usuario'],
            'password' => [$requiredIfNovoCoordenador, 'string', 'min:8', 'confirmed'],
            'password_confirmation' => [$requiredIfNovoCoordenador, 'string', 'min:8'],
            'professor' => [$requiredIfPromoverProfessor, 'integer', 'exists:users,id'],
            'instituicao' => ['required', 'integer', 'exists:instituicoes,id']
        ];
    }
}
