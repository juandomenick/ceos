<?php

namespace App\Helpers;

/**
 *  Funções de auxilio de manipulação de strings
 */
class StringHelper
{
    /**
     * upper - Função que formata a string para o formato correto para validação em maiusculo
     *
     * @param string $string
     * @return string
     */
    public function upper($string)
    {
        return $string ? mb_strtoupper($string) : null;
    }

    /**
     * lower - Função que formata a string para o formato correto para validação em minusculo
     *
     * @param string $string
     * @return string
     */
    public function lower($string)
    {
        return $string ? mb_strtolower($string) : null;
    }

    /**
     * filter - Função que formata a string para o formato correto para validação, aceitando somente letras, numeros e alguns tipos de caracteres especiais
     *
     * @param string $string
     * @return string
     */
    public function filter($string)
    {
        return $string ? preg_replace('/[^a-zA-Z0-9çÇáÁéÉíÍóÓúÚãÃõÕâÂêÊîÎôÔûÛüÜàÀèÈìÌòÒùÙ\s\-\/\(\)]/', '', trim($string)) : null;
    }

    /**
     * trimAll - Função que retira todos os espaços e quebras de linha de uma string
     *
     * @param string $string
     * @return string
     */
    public function trimAll($string)
    {
        return $string ? preg_replace('/[\s\t\n\r]+/', '', trim($string)) : null;
    }

    /**
     * cnpj - Função que formata a string para o formato correto do CNPJ
     *
     * @param string $string
     * @return string
     */
    public function cnpj($string)
    {
        // REMOVE TODOS OS CARACTERES QUE NÃO SÃO NUMEROS
        $cnpj = preg_replace('/[^0-9]/', '', $string);

        // VALIDA SE O TAMANHO ESTÁ VALIDO
        if (strlen($cnpj) == 14) {
            return vsprintf('%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s', str_split($cnpj));
        } else {
            return false;
        }
    }

    /**
     * cpf - Função que formata a string para o formato correto do CPF
     *
     * @param string $string
     * @return string
     */
    public function cpf($string)
    {
        // REMOVE TODOS OS CARACTERES QUE NÃO SÃO NUMEROS
        $cpf = preg_replace('/[^0-9]/', '', $string);

        // VALIDA SE O TAMANHO ESTÁ VALIDO
        if (strlen($cpf) == 14) {
            return vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($cpf));
        } else {
            return false;
        }
    }

    /**
     * cpf_cnpj - Função que formata a string para o formato correto do CPF ou CNPJ
     *
     * @param string $string
     * @return string
     */
    public function cpf_cnpj($string)
    {
        // REMOVE TODOS OS CARACTERES QUE NÃO SÃO NUMEROS
        $doc = preg_replace('/[^0-9]/', '', $string);

        // VALIDA SE O TAMANHO ESTÁ VALIDO
        if (in_array(strlen($doc), [11, 14])) {
            // CPF
            if (strlen($doc) === 11) {
                return vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($doc));
            }

            // CNPJ
            if (strlen($doc) === 14) {
                return vsprintf('%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s', str_split($doc));
            }
        } else {
            return false;
        }
    }

    /**
     * compare - Função que retira os espaços da string, coloca tudo maiusculo e compara para ver se as strings são iguais
     *
     * @param string $string_a
     * @param string $string_b
     * @return string
     */
    public function compare($string_a, $string_b)
    {
        // VALIDA SE CONTÉM AS DUAS STRINGS
        if (strlen($string_a) && strlen($string_b)) {
            if ($this->upper($this->trimAll($string_a)) == $this->upper($this->trimAll($string_b))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * contains - Função que verifica se a string_b existe dentro da string_a
     *
     * @param string $string_a
     * @param mixed $mixed
     * @return bool
     */
    public function contains($string_a, $mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $str) {
                if (str_contains(
                    $this->upper(trim($string_a)),
                    $this->upper(trim($str))
                )) {
                    return true;
                }
            }
            return false;
        } else if (is_string($mixed)) {
            return str_contains(
                $this->upper(trim($string_a)),
                $this->upper(trim($mixed))
            );
        } else {
            return false;
        }
    }
}
