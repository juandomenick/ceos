<?php

namespace App\Http\Requests\Usuarios\Aluno;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AtualizarAlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('administrador|professor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::where('email', $this->request->get('email'))->first();

        return [
            'nome' => ['required', 'string'],
            'prontuario' => ['required', 'string', Rule::unique('alunos', 'prontuario')->ignore($user->aluno->id)],
            'celular'  => ['required', 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
        ];
    }
}
