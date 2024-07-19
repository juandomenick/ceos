<?php

namespace App\Models\Academico\Turmas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtividadeTurma extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'atividades_turma';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'turma_id',
        'professor_id',
        'titulo',
        'descricao',
        'pontos',
        'data_entrega',
        'concluida',
        'ativo',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'concluida' => 'bool',
        'ativo' => 'bool',
    ];

    /**
     * Relacionamento Nx1: Atividade pertence a uma Turma.
     *
     * @return BelongsTo
     */
    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }

    /**
     * Mutator - Atributo: data_entrega.
     *
     * @param $value
     * @return string
     */
    public function getDataEntregaAttribute($value): string
    {
        return Carbon::parse($value)->toDateTimeLocalString();
    }
}
