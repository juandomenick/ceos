<?php

namespace App\Repositories\Academico\Turmas;

use App\Criteria\Academico\Turmas\AtividadeTurmaCriteria;
use App\Models\Academico\Turmas\AtividadeTurma;
use App\Models\Academico\Turmas\Turma;
use App\Repositories\Interfaces\Academico\Turmas\AtividadeTurmaRepository;
use App\Services\Academico\GoogleClassroomService;
use App\Transformers\Academico\Turmas\AtividadeTurmaClassroomTransformer;
use Carbon\Carbon;
use Google_Service_Classroom_CourseWork;
use Google_Service_Classroom_Date;
use Google_Service_Classroom_TimeOfDay;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityCreating;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Prettus\Repository\Events\RepositoryEntityDeleting;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Events\RepositoryEntityUpdating;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AtividadeTurmaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico\Turmas;
 */
class AtividadeTurmaRepositoryEloquent extends BaseRepository implements AtividadeTurmaRepository
{
    /**
     * @var AtividadeTurmaClassroomTransformer
     */
    private $atividadeTurmaClasroomTransformer;

    /**
     * AtividadeTurmaRepositoryEloquent constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->atividadeTurmaClasroomTransformer = new AtividadeTurmaClassroomTransformer();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AtividadeTurma::class;
    }

    /**
     * @param int $turmaId
     * @param string[] $columns
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function getByTurma(int $turmaId, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        if (is_null(Turma::find($turmaId))) {
            $turmaClassroom = GoogleClassroomService::getService()->courses->get($turmaId);

            if (is_null($turmaClassroom)) {
                throw new ModelNotFoundException();
            }

            $results = collect(GoogleClassroomService::getService()->courses_courseWork->listCoursesCourseWork($turmaId))
                ->map(function ($atividadeTurmaClassroom)  {
                    return $this->atividadeTurmaClasroomTransformer->transform($atividadeTurmaClassroom);
                });

            return $this->parserResult($results);
        }

        $results = $this->model->where('turma_id', $turmaId)->get($columns);

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    /**
     * @param $id
     * @param string[] $columns
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function findById(int $id, int $turmaId, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->find($id, $columns);

        if (is_null($model)) {
            $model = GoogleClassroomService::getService()->courses_courseWork->get($turmaId, $id);

            if (is_null($model)) {
                throw new ModelNotFoundException();
            }

            $model = (object) $this->atividadeTurmaClasroomTransformer->transform($model);

            return $this->parserResult($model);
        }

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Delete a entity in repository by id
     *
     * @param int $id
     * @param int $turmaId
     * @return int
     * @throws RepositoryException
     */
    public function deleteById(int $id, int $turmaId)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->findById($id, $turmaId);
        $originalModel = clone $model;

        if (!collect($model)->has('professor_id')) {
            $model = GoogleClassroomService::getService()->courses_courseWork->get($turmaId, $id);

            if (is_null($model)) {
                throw new ModelNotFoundException();
            }

            GoogleClassroomService::getService()->courses_courseWork->delete($turmaId, $id);

            return true;
        }

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityDeleting($this, $model));

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function create(array $attributes)
    {
        if (!is_null($this->validator)) {
            if ($this->versionCompare($this->app->version(), "5.2.*", ">")) {
                $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
            } else {
                $model = $this->model->newInstance()->forceFill($attributes);
                $model->makeVisible($this->model->getHidden());
                $attributes = $model->toArray();
            }

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }

        event(new RepositoryEntityCreating($this, $attributes));

        $model = $this->model->newInstance($attributes);

        if (is_null(Turma::find($attributes['turma_id']))) {
            $atividade = new Google_Service_Classroom_CourseWork();

            $dataHoraEntrega = Carbon::parse($attributes['data_entrega']);
            $this->setDataEntrega($atividade, $dataHoraEntrega);

            $atividade->title = $attributes['titulo'];
            $atividade->description = $attributes['descricao'];
            $atividade->maxPoints = $attributes['pontos'];
            $atividade->state = 'PUBLISHED';
            $atividade->workType = 'ASSIGNMENT';

            $model = GoogleClassroomService::getService()->courses_courseWork->create($attributes['turma_id'], $atividade);

            return $this->parserResult($model);
        }

        $model->save();
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();

        if (!is_null($this->validator)) {
            if ($this->versionCompare($this->app->version(), "5.2.*", ">")) {
                $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
            } else {
                $model = $this->model->newInstance()->forceFill($attributes);
                $model->makeVisible($this->model->getHidden());
                $attributes = $model->toArray();
            }

            $this->validator->with($attributes)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->find($id);

        if (!collect($model)->has('professor_id')) {
            $atividade = GoogleClassroomService::getService()->courses_courseWork->get($attributes['turma_id'], $id);

            if (is_null($atividade)) {
                throw new ModelNotFoundException();
            }

            $dataHoraEntrega = Carbon::parse($attributes['data_entrega']);
            $this->setDataEntrega($atividade, $dataHoraEntrega);

            $atividade->setTitle($attributes['titulo']);
            $atividade->setDescription($attributes['descricao']);
            $atividade->setMaxPoints($attributes['pontos']);

            $options = [
                'updateMask' => 'title,description,maxPoints,dueDate,dueTime',
            ];

            $atividade = GoogleClassroomService::getService()
                ->courses_courseWork
                ->patch($attributes['turma_id'], $id, $atividade, $options);

            return $this->parserResult($atividade);
        }

        event(new RepositoryEntityUpdating($this, $model));

        $model->fill($attributes);
        $model->save();

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }

    /**
     * Preenche os atributos de data e hora de entrega da atividade.
     *
     * @param Google_Service_Classroom_CourseWork $atividade
     * @param Carbon $dataHoraEntrega
     */
    private function setDataEntrega(Google_Service_Classroom_CourseWork &$atividade, Carbon $dataHoraEntrega): void
    {
        $dataEntrega = new Google_Service_Classroom_Date();
        $dataEntrega->setDay($dataHoraEntrega->day);
        $dataEntrega->setMonth($dataHoraEntrega->month);
        $dataEntrega->setYear($dataHoraEntrega->year);

        $horaEntrega = new Google_Service_Classroom_TimeOfDay();
        $horaEntrega->setHours($dataHoraEntrega->hour);
        $horaEntrega->setMinutes($dataHoraEntrega->minute);

        $atividade->setDueDate($dataEntrega);
        $atividade->setDueTime($horaEntrega);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(AtividadeTurmaCriteria::class));
    }
    
}
