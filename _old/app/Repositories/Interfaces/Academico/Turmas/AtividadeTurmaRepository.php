<?php

namespace App\Repositories\Interfaces\Academico\Turmas;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AtividadeTurmaRepository.
 *
 * @package namespace App\Repositories\Interfaces\Academico\Turmas;
 */
interface AtividadeTurmaRepository extends RepositoryInterface
{
    public function getByTurma(int $turmaId, array $columns = ['*']);

    public function findById(int $id, int $turmaId, array $columns = ['*']);

    public function deleteById(int $id, int $turmaId);
}
