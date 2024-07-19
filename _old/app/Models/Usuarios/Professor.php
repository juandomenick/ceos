<?php

namespace App\Models\Usuarios;

use App\Models\Academico\AnotacaoAula;
use App\Models\Academico\Atividade;
use App\Models\Academico\Curso;
use App\Models\Academico\Questoes\Questao;
use App\Models\Academico\Turmas\Turma;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Professor
 *
 * @package App\Models\Usuarios
 */
class Professor extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'professores';

    /**
     * Atributos que são assinaláveis em massa.
     *
     * @var array
     */
    protected $fillable = ['matricula'];

    /**
     * Relacionamento 1x1: Professor é um Usuário.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento NxN: Professor pertence a vários Cursos.
     *
     * @return BelongsToMany
     */
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_professor', 'professor_id', 'curso_id');
    }

    /**
     * Relacionamento 1xN: Professor tem várias Questões.
     *
     * @return HasMany
     */
    public function questoes(): HasMany
    {
        return $this->hasMany(Questao::class);
    }

    /**
     * Relacionamento 1xN: Professor tem várias Atividades.
     *
     * @return HasMany
     */
    public function atividades(): HasMany
    {
        return $this->hasMany(Atividade::class);
    }

    /**
     * Relacionamento 1xN: Professor tem várias Turmas.
     *
     * @return HasMany
     */
    public function turmas(): HasMany
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Relacionamento 1xN: Professor tem várias Anotações.
     *
     * @return HasMany
     */
    public function anotacoesAula(): HasMany
    {
        return $this->hasMany(AnotacaoAula::class);
    }
}
