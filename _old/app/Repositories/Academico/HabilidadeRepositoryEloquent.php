<?php

namespace App\Repositories\Academico;

use App\Exceptions\TransactionException;
use App\Models\Academico\Habilidade;
use App\Repositories\Interfaces\Academico\HabilidadeRepository;
use Exception;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Prettus\Repository\Events\RepositoryEntityDeleting;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class QuestaoRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class HabilidadeRepositoryEloquent extends BaseRepository implements HabilidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Habilidade::class;
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

        if ($model->questoes->count()) {
            throw new TransactionException('A habilidade não pode ser removida pois esta associada a questões.');
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
