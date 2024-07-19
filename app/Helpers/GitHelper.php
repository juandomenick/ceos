<?php

namespace App\Helpers;

use Gitonomy\Git\Repository;

/**
 *  Funções da biblioteca do git
 */
class GitHelper
{

    /**
     * version - Função que retorna uma versão para a exibição
     *
     * @return Version
     */
    public function version()
    {
        $version = 0;

        try {
            // PUXANDO O GIT DO REPOSITORIO
            $repo = new Repository(
                base_path()
            );

            // CONSTRUINDO VERSÃO
            $version = '0.' . date('Y') . '.' . str_pad(count($repo->getLog('main')), 4, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            // SE NÃO CONSEGUIR CONECTAR NA BIBLIOTECA
            $version = '0' . date('Y');
        }

        // RETORNA A VERSAO
        return $version;
    }
}
