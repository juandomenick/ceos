<?php

namespace App\Repositories\Academico;

use App\Criteria\Academico\Equipes\EquipeCriteria;
use App\Models\Academico\Equipe;
use App\Repositories\Interfaces\Academico\EquipeRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityCreating;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Events\RepositoryEntityUpdating;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class EquipeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class EquipeRepositoryEloquent extends BaseRepository implements EquipeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Equipe::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(EquipeCriteria::class);
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function create(array $attributes)
    {
        event(new RepositoryEntityCreating($this, $attributes));

        $model = $this->model->newInstance($attributes);
        $model->save();
        $model->alunos()->sync($attributes['alunos'] ?? []);
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->findOrFail($id);

        event(new RepositoryEntityUpdating($this, $model));

        $model->fill($attributes);
        $model->save();
        $model->alunos()->sync($attributes['alunos'] ?? []);

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }
}
