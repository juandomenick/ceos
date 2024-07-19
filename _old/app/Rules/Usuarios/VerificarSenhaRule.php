<?php

namespace App\Rules\Usuarios;

use Illuminate\Contracts\Validation\Rule;

class VerificarSenhaRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Verifica se a senha atual informada corresponde à armazenada no banco de dados
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return password_verify($value, auth()->user()->getAuthPassword());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A senha atual está incorreta';
    }
}
