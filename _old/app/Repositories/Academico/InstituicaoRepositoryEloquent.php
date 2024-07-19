<?php

namespace App\Repositories\Academico;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Academico\InstituicaoRepository;
use App\Models\Academico\Instituicao;

/**
 * Class InstituicaoRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class InstituicaoRepositoryEloquent extends BaseRepository implements InstituicaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Instituicao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
