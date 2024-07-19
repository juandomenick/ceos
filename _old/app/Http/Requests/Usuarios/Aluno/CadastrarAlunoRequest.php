<?php

namespace App\Http\Requests\Usuarios\Aluno;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CadastrarAlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ruleCpf = Rule::requiredIf(
            $this->request->get('data_nascimento') !== null &&
            eMenorDeIdade($this->request->get('data_nascimento'))
        );

        return [
            'nome'=> ['required', 'string'],
            'data_nascimento' => ['required', 'string', 'date'],
            'cpf_responsavel' => [$ruleCpf, 'string', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/i'],
            'prontuario'=> ['required', 'string', 'unique:alunos'],
            'celular' => ['required', 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'usuario' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8']
        ];
    }
}
