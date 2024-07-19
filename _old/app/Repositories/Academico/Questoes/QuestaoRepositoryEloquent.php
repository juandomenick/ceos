<?php

namespace App\Repositories\Academico\Questoes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Academico\Questoes\QuestaoRepository;
use App\Models\Academico\Questoes\Questao;

/**
 * Class QuestaoRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class QuestaoRepositoryEloquent extends BaseRepository implements QuestaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Questao::class;
    }

    /**
     * Duplica Questão.
     *
     * @param int $id
     * @return mixed
     */
    public function duplicate(int $id)
    {
        return DB::transaction(function () use ($id) {
            $model = $this->model->findOrFail($id);
            $model->professor_id = Auth::user()->professor->id;

            $newModel = $this->model->newInstance($model->toArray());
            $newModel->save();

            if ($model->alternativas) {
                $alternativas = array();

                foreach ($model->alternativas as $alternativa) {
                    array_push($alternativas, [
                        'questao_id' => $newModel->id,
                        'descricao' => $alternativa->descricao,
                        'alternativa_correta' =>  $alternativa->alternativa_correta
                    ]);
                }

                $newModel->alternativas()->createMany($alternativas);
            }

            return $newModel;
        });
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
