<?php

namespace App\Repositories\Academico\Questoes;

use App\Models\Academico\Questoes\Alternativa;
use App\Repositories\Interfaces\Academico\Questoes\AlternativaQuestaoRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class AlternativaQuestaoRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico\Questoes;
 */
class AlternativaRepositoryEloquent extends BaseRepository implements AlternativaQuestaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Alternativa::class;
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance($attributes);
        $model->save();
        $this->resetModel();

        $this->tornarAlternativasFalsas($model, $attributes);

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

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        $this->tornarAlternativasFalsas($model, $attributes);

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param $model
     * @param array $attributes
     */
    private function tornarAlternativasFalsas($model, array $attributes): void
    {
        if (isset($attributes['alternativa_correta']) && $attributes['alternativa_correta']) {
            foreach ($model->questao->alternativas as $alternativa) {
                if ($alternativa->id != $model->id) {
                    $alternativa->update(['alternativa_correta' => false]);
                }
            }
        }
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
