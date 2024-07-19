<?php

namespace App\Repositories\Academico\Atividades;

use App\Models\Academico\AtividadeDesignavel;
use App\Models\Academico\Equipe;
use App\Models\Academico\Questoes\Alternativa;
use App\Models\Academico\Questoes\Questao;
use App\Models\Academico\Turmas\Turma;
use App\Models\Usuarios\Aluno;
use App\Repositories\Interfaces\Academico\Atividades\AtividadeDesignavelRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityCreating;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AtividadeDesignavelRepositoryEloquent.
 *
 * @package namespace App\Repositories\Academico;
 */
class AtividadeDesignavelRepositoryEloquent extends BaseRepository implements AtividadeDesignavelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AtividadeDesignavel::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator|Collection|mixed
     * @throws Exception
     */
    public function create(array $attributes)
    {
        event(new RepositoryEntityCreating($this, $attributes));

        switch ($attributes['designar_para']) {
            case 'turma':
                $entidade = Turma::findOrfail($attributes['turma_id']); break;
            case 'equipe':
                $entidade = Equipe::findOrfail($attributes['equipe_id']); break;
            default:
                $entidade = Aluno::findOrfail($attributes['aluno_id']); break;
        }

        if ($entidade->atividadesDesignadas()->where('atividade_id', $attributes['atividade_id'])->get()->count()) {
            throw new Exception('Esta atividade já foi designada para este destinatário.');
        }

        $model = $entidade->atividadesDesignadas()->create($attributes);

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator|Collection|mixed
     * @throws ValidatorException
     */
    public function responder(array $attributes)
    {
        $atividade = $this->update(['respondida' => true], $attributes['atividade_id']);

        foreach ($attributes['questoes'] as $key => $value) {
            $questao = Questao::where('id', $key)->first();

            $respostaCorreta = $questao->tipo === 'Alternativa' ? Alternativa::where('id', $value)->first()->alternativa_correta : false;

            $questao->respostas()->create([
                'atividade_designada_id' => $attributes['atividade_id'],
                'aluno_id' => $attributes['aluno_id'],
                'resposta' => $value,
                'resposta_correta' => $respostaCorreta
            ]);
        }

        return  $this->parserResult($atividade);
    }
}
