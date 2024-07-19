<?php

namespace App\Models\Academico;

use App\Models\Academico\Turmas\Turma;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Disciplina
 *
 * @package App\Models\Academico
 */
class Disciplina extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'disciplinas';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'curso_id',
        'nome',
        'sigla',
        'ativo',
    ];

    /**
     * Relacionamento Nx1: Disciplina pertence a um Curso.
     *
     * @return BelongsTo
     */
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * Relacionamento 1xN: Disciplina tem várias Turmas.
     *
     * @return HasMany
     */
    public function turmas(): HasMany
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Relacionamento 1xN: Disciplina tem várias Atividades.
     *
     * @return HasMany
     */
    public function atividades(): HasMany
    {
        return $this->hasMany(Disciplina::class);
    }
}
