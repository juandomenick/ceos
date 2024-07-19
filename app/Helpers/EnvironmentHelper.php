<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 *  Funções que consulta o ambiente conectado
 */
class EnvironmentHelper
{
    /**
     * current - Função que retorna qual ambiente está conectado
     *
     * @return string
     */
    public function atual()
    {
        $database = explode('-', DB::connection(session()->get('database_core'))->getDatabaseName());
        if (@$database[1]) {
            if (in_array($env = mb_strtoupper($database[1]), ['PROD', 'SAND', 'DEV'])) {
                return $env;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
