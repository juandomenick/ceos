<?php

namespace App\Models\Academico;

use App\Models\Usuarios\Coordenador;
use App\Models\Usuarios\Professor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Curso
 * 
 * @package App\Models\Academico
 */
class Curso extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'cursos';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'instituicao_id',
        'coordenador_id',
        'nome',
        'sigla',
        'ativo',
        'nivel',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'disciplinas',
        'professores.user'
    ];

    /**
     * Relacionamento Nx1: Curso pertence a uma Instituição
     *
     * @return BelongsTo
     */
    public function instituicao(): BelongsTo
    {
        return $this->belongsTo(Instituicao::class);
    }

    /**
     * Relacionamento Nx1: Curso pertence a um Usuário (Coordenador)
     *
     * @return BelongsTo
     */
    public function coordenador(): BelongsTo
    {
        return $this->belongsTo(Coordenador::class);
    }

    /**
     * Relacionamento NxN: Curso tem vários Usuários (Professor).
     *
     * @return BelongsToMany
     */
    public function professores(): BelongsToMany
    {
        return $this->belongsToMany(Professor::class, 'curso_professor', 'curso_id', 'professor_id');
    }

    /**
     * Relacionamento 1xN: Curso tem várias Disciplinas.
     *
     * @return HasMany
     */
    public function disciplinas(): HasMany
    {
        return $this->hasMany(Disciplina::class);
    }

    /**
     * Mutator: Retorna array contento os IDs dos professores relacionados ao curso.
     *
     * @return array
     */
    public function getProfessoresIdAttribute(): array
    {
        return $this->professores->map(function ($professor) {
            return $professor->id;
        })->toArray();
    }
}
