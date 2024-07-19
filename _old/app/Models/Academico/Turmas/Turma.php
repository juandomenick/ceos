<?php

namespace App\Models\Academico\Turmas;

use App\Models\Academico\AnotacaoAula;
use App\Models\Academico\AtividadeDesignavel;
use App\Models\Academico\Disciplina;
use App\Models\Academico\Equipe;
use App\Models\Usuarios\Aluno;
use App\Models\Usuarios\Professor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Turma
 *
 * @property mixed alunos
 * @package App\Models\Academico
 */
class Turma extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'turmas';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'sigla', 'ano', 'semestre', 'codigo_acesso', 'ativo', 'disciplina_id', 'professor_id'
    ];

    /**
     * Relacionamento Nx1: Turma pertence a uma Disciplina
     *
     * @return BelongsTo
     */
    public function disciplina(): BelongsTo
    {
        return $this->belongsTo(Disciplina::class);
    }

    /**
     * Relacionamento Nx1: Turma pertence a um Professor
     *
     * @return BelongsTo
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Relacionamento NxN: Turma tem vários Alunos.
     *
     * @return BelongsToMany
     */
    public function alunos(): BelongsToMany
    {
        return $this->belongsToMany(Aluno::class, 'aluno_turma', 'turma_id', 'aluno_id');
    }

    /**
     * Relacionamento 1xN: Turma tem várias Equipes.
     * @return HasMany
     */
    public function equipes(): HasMany
    {
        return $this->hasMany(Equipe::class);
    }

    /**
     * Relacionamento 1xN: Turma tem várias Anotações.
     *
     * @return HasMany
     */
    public function anotacoesAula(): HasMany
    {
        return $this->hasMany(AnotacaoAula::class);
    }

    /**
     * Relacionamento 1xN: Turma tem várias Atividades Designadas.
     *
     * @return MorphMany
     */
    public function atividadesDesignadas(): MorphMany
    {
        return $this->morphMany(AtividadeDesignavel::class, 'atividade_designavel');
    }

    /**
     * Relacionamento 1xN: Turma tem várias Atividades Designadas.
     *
     * @return HasMany
     */
    public function atividadeTurma(): HasMany
    {
        return $this->hasMany(AtividadeTurma::class);
    }

    /**
     * @return mixed
     */
    public function getCursoAttribute()
    {
        return $this->disciplina->curso;
    }
}
