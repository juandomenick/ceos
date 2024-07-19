<?php

namespace App\Models\Academico;

use App\Models\Academico\Turmas\Turma;
use App\Models\Usuarios\Aluno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Equipe
 * @package App\Models\Academico
 */
class Equipe extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'equipes';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'data_formacao', 'ativo', 'turma_id'
    ];

    /**
     * Relacionamento Nx1: Equipe pertence a uma Turma.
     *
     * @return BelongsTo
     */
    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }

    /**
     * Relacionamento NxN: Equipe tem vários Alunos.
     *
     * @return BelongsToMany
     */
    public function alunos(): BelongsToMany
    {
        return $this->belongsToMany(Aluno::class, 'aluno_equipe', 'equipe_id', 'aluno_id');
    }

    /**
     * Relacionamento 1xN: Equipe tem várias Atividades Designadas.
     *
     * @return MorphMany
     */
    public function atividadesDesignadas(): MorphMany
    {
        return $this->morphMany(AtividadeDesignavel::class, 'atividade_designavel');
    }
}
