<?php

namespace App\Models\Academico;

use App\Models\Academico\Turmas\Turma;
use App\Models\Usuarios\Professor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AnotacaoAula.
 *
 * @package namespace App\Models\Academico;
 */
class AnotacaoAula extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'anotacoes_aula';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'professor_id',
        'turma_id',
        'aluno',
        'descricao',
        'data',
        'hora',
        'assinatura',
    ];

    /**
     * Relacionamento Nx1: Anotação pertence a um Professor.
     *
     * @return BelongsTo
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Relacionamento Nx1: Anotação pertence a uma Turma.
     *
     * @return BelongsTo
     */
    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }
}
