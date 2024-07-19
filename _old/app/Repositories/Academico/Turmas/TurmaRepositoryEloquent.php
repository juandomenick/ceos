<?php

namespace App\Repositories\Academico\Turmas;

use App\Criteria\Academico\Turmas\TurmaCriteria;
use App\Exceptions\TransactionException;
use App\Models\Academico\Turmas\Turma;
use App\Models\Usuarios\Aluno;
use App\Repositories\Interfaces\Academico\Turmas\TurmaRepository;
use App\Services\Academico\GoogleClassroomService;
use App\Transformers\Academico\Turmas\TurmaClassroomTransformer;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityCreating;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Events\RepositoryEntityUpdating;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class TurmaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class TurmaRepositoryEloquent extends BaseRepository implements TurmaRepository
{
    /**
     * @var TurmaClassroomTransformer
     */
    private $turmaClassroomTransformer;

    /**
     * TurmaRepositoryEloquent constructor.
     *
     * @param Application $app
     * @param TurmaClassroomTransformer $transformer
     */
    public function __construct(Application $app, TurmaClassroomTransformer $transformer)
    {
        parent::__construct($app);

        $this->turmaClassroomTransformer = $transformer;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Turma::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(TurmaCriteria::class);
    }

    /**
     * @param string[] $columns
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $turmasClassroom = collect();

        $results = $this->model instanceof Builder ? $this->model->get($columns): $this->model->all($columns);

        if (Session::get('tokenGoogle')) {
            $googleService = GoogleClassroomService::getService();

            $turmasClassroom = collect($googleService->courses->listCourses())
                ->map(function ($turma) {
                    return $this->turmaClassroomTransformer->transform($turma);
                });
        }

        $results = $turmasClassroom->merge(collect($results));

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
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->find($id, $columns);

        if (is_null($model)) {
            $googleService = GoogleClassroomService::getService();

            $model = $googleService->courses->get($id);

            if (is_null($model)) {
                throw new ModelNotFoundException();
            }

            $model = (object) $this->turmaClassroomTransformer->transform($model);

            $alunos = collect($googleService->courses_students->listCoursesStudents($id))
                ->map(function ($aluno) {
                    return [
                        'id' => $aluno->profile->id,
                        'nome' => $aluno->profile->name->fullName
                    ];
                });

            $model->alunosId = $alunos->pluck('id');
            $model->alunos = $alunos->pluck('nome', 'id');
        } else {
            $model->alunosId = $model->alunos->pluck('id');
            $model->alunos = Aluno::all()->pluck('user.nome', 'id');
        }

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function create(array $attributes)
    {
        event(new RepositoryEntityCreating($this, $attributes));

        $data = (int) date('mYHs') / 4;
        $siglaTurma = str_replace(' ', "", $attributes['sigla']);

        $attributes['codigo_acesso'] = Str::upper($data . '#' . $siglaTurma . '_' . Str::random(4));

        $model = $this->model->newInstance($attributes);

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

        if (collect($model)->has('professor_id')) {
            event(new RepositoryEntityUpdating($this, $model));

            $model->fill($attributes);
            $model->save();

            $model->alunos()->sync($attributes['alunos'] ?? []);

            $this->skipPresenter($temporarySkipPresenter);
            $this->resetModel();

            event(new RepositoryEntityUpdated($this, $model));
        } else {
            $model = GoogleClassroomService::getService()->courses->get($id);

            if (is_null($model)) {
                throw new ModelNotFoundException();
            }

            $model->name = $attributes['nome'];
            $model->section = $attributes['sigla'];
            $model->courseState = $attributes['ativo'];
            $model = GoogleClassroomService::getService()->courses->update($id, $model);
        }

        return $this->parserResult($model);
    }

    /**
     * @param string $codigoTurma
     * @return void
     * @throws TransactionException
     */
    public function ingressarAluno(string $codigoTurma): void
    {
        $turma = $this->model->where('codigo_acesso', $codigoTurma)->first();

        if ($turma->alunos()->where([['turma_id', $turma->id], ['aluno_id', auth()->user()->aluno->id]])->first()) {
            throw new TransactionException('Você já pertence a essa turma.');
        }

        $turma->alunos()->attach(auth()->user()->aluno->id);
    }
}
