<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AtualizarUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => ['required', 'string'],
            'celular'  => ['required', 'string', 'min:15', 'max:15', 'regex:/^\([1-9]\d\)\s9\d{4}-\d{4}$/i'],
            'telefone' => ['nullable', 'string', 'min:14',  'max:14', 'regex:/^\([1-9]\d\)\s[0-9]{4}-[0-9]{4}$/i'],
            'usuario' => ['required', 'string', 'max:20', Rule::unique('users', 'usuario')->ignore(Auth::user()->getAuthIdentifier())],
            'avatar' => ['nullable', 'file', 'max:3072', 'image']
        ];
    }
}
