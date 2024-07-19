<?php

namespace App\Repositories\Usuarios;

use App\Criteria\Usuarios\Alunos\AlunoCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Interfaces\Usuarios\AlunoRepository;
use App\Models\Usuarios\Aluno;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class AlunoRepositoryEloquent.
 *
 * @package namespace App\Repositories\Usuarios;
 */
class AlunoRepositoryEloquent extends BaseRepository implements AlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Aluno::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(AlunoCriteria::class);
    }
}
