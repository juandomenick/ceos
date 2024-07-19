<?php

namespace App\Repositories\Interfaces\Academico\Turmas;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TurmaRepository.
 *
 * @package namespace App\Repositories\Interfaces\Academico;
 */
interface TurmaRepository extends RepositoryInterface
{
    /**
     * Realiza ingresso de Aluno em Turma.
     *
     * @param string $codigoTurma
     * @return void
     */
    public function ingressarAluno(string $codigoTurma): void;
}
