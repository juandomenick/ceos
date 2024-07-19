<?php

namespace App\Models\Usuarios;

use App\Models\Academico\AtividadeDesignavel;
use App\Models\Academico\Equipe;
use App\Models\Academico\Questoes\Resposta;
use App\Models\Academico\Turmas\Turma;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Aluno
 *
 * @package App\Models\Usuarios
 */
class Aluno extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'alunos';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'prontuario', 'responsavel_id'
    ];

    /**
     * Relacionamento 1xN: Aluno tem várias Respostas.
     *
     * @return HasMany
     */
    public function respostas(): HasMany
    {
        return $this->hasMany(Resposta::class);
    }

    /**
     * Relacionamento 1x1: Responsável é um Usuário.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento Nx1: Aluno pertence a um Responsável
     *
     * @return BelongsTo
     */
    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(ResponsavelAluno::class);
    }

    /**
     * Relacionamento NxN: Aluno pertence a várias Turmas.
     *
     * @return BelongsToMany
     */
    public function turmas(): BelongsToMany
    {
        return $this->belongsToMany(Turma::class, 'aluno_turma', 'aluno_id', 'curso_id');
    }

    /**
     * Relacionamento NxN: Aluno pertence a várias Equipes.
     *
     * @return BelongsToMany
     */
    public function equipes(): BelongsToMany
    {
        return $this->belongsToMany(Equipe::class, 'aluno_equipe', 'aluno_id', 'equipe_id');
    }

    /**
     * Relacionamento 1xN: Aluno tem várias Atividades Designadas.
     *
     * @return MorphMany
     */
    public function atividadesDesignadas(): MorphMany
    {
        return $this->morphMany(AtividadeDesignavel::class, 'atividade_designavel');
    }
}
