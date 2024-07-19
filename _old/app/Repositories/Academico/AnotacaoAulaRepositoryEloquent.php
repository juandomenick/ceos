<?php

namespace App\Repositories\Academico;

use App\Criteria\Academico\AnotacoesAula\AnotacaoAulaCriteria;
use App\Models\Academico\AnotacaoAula;
use App\Repositories\Interfaces\Academico\AnotacaoAulaRepository;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class AnotacaoAulaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class AnotacaoAulaRepositoryEloquent extends BaseRepository implements AnotacaoAulaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnotacaoAula::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(AnotacaoAulaCriteria::class);
    }
}
