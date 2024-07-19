<?php

namespace App\Helpers;

/**
 *  Funções de encriptação e desincriptação
 */
class SecurityHelper
{

    /**
     * encrypt - Função que faz a encriptação da string passada e retorna uma string
     *
     * @param String
     * @return String
     */
    public function encrypt($string)
    {
        return strlen($string) ? str_replace("+", "!", str_replace("/", "@", openssl_encrypt($string, "AES-128-ECB", 'RxRe4g50fxD33dx049xrg432pp03', 0, ''))) : null;
    }

    /**
     * decrypt - Função que faz a descriptação da string passada e retorna uma string
     *
     * @param String
     * @return String
     */
    public function decrypt($string)
    {
        return strlen($string) ? openssl_decrypt(trim(str_replace("!", "+", str_replace("@", "/", $string))), "AES-128-ECB", 'RxRe4g50fxD33dx049xrg432pp03', 0, '') : null;
    }
}
