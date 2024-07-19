<?php

namespace App\Http\Requests\Usuarios\Diretor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CadastrarDiretorRequest extends FormRequest
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
        $tipoCadastro = $this->request->get('tipo-cadastro');

        $requiredIfNovoDiretor = $tipoCadastro === 'novo-diretor' ? 'required' : 'nullable';
        $requiredIfPromoverProfessor = $tipoCadastro === 'promover-professor' ? 'required' : 'nullable';

        return [
            'nome' => [$requiredIfNovoDiretor, 'string'],
            'celular' => [$requiredIfNovoDiretor, 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'email' => [$requiredIfNovoDiretor, 'string', 'email', 'unique:users,email'],
            'usuario' => [$requiredIfNovoDiretor, 'string', 'max:20', 'unique:users,usuario'],
            'password' => [$requiredIfNovoDiretor, 'string', 'min:8', 'confirmed'],
            'password_confirmation' => [$requiredIfNovoDiretor, 'string', 'min:8'],
            'professor' => [$requiredIfPromoverProfessor, 'integer', 'exists:users,id']
        ];
    }
}
