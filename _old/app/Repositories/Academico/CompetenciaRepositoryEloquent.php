<?php

namespace App\Repositories\Academico;

use App\Exceptions\TransactionException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Academico\CompetenciaRepository;
use App\Models\Academico\Competencia;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Prettus\Repository\Events\RepositoryEntityDeleting;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class CompetenciaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class CompetenciaRepositoryEloquent extends BaseRepository implements CompetenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Competencia::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $id
     * @return int
     * @throws RepositoryException
     * @throws TransactionException
     */
    public function delete($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->find($id);

        if ($model->habilidades->count()) {
            throw new TransactionException('A competência não pode ser removida pois esta associada a habilidades.');
        }

        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityDeleting($this, $model));

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }
}
