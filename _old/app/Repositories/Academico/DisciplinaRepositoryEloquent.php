<?php

namespace App\Repositories\Academico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Academico\DisciplinaRepository;
use App\Models\Academico\Disciplina;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class DisciplinaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class DisciplinaRepositoryEloquent extends BaseRepository implements DisciplinaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Disciplina::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
