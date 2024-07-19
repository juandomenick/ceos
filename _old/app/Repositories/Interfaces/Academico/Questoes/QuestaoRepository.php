<?php

namespace App\Repositories\Interfaces\Academico\Questoes;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface QuestaoRepository.
 *
 * @package namespace App\Repositories\Interfaces\Academico;
 */
interface QuestaoRepository extends RepositoryInterface
{
    /**
     * Duplica Questão.
     *
     * @param int $id
     * @return mixed
     */
    public function duplicate(int $id);
}
