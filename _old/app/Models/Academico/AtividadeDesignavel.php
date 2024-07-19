<?php

namespace App\Models\Academico;

use App\Models\Academico\Questoes\Resposta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class AtividadeDesignada
 *
 * @package App\Models\Academico
 */
class AtividadeDesignavel extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'atividades_designadas';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'atividade_id',
        'descricao',
        'pontos',
        'tempo',
        'atividade_designavel_id',
        'atividade_designavel_type',
        'ativo',
        'respondida',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'ativo' => 'bool',
        'respondida' => 'bool',
    ];

    /**
     * Relacionamento Polimórfico: Entidade pode ter Atividade Designável.
     *
     * @return MorphTo
     */
    public function atividadeDesignavel(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relacionamento Nx1: Atividade Designavel pertence a uma Atividade.
     *
     * @return BelongsTo
     */
    public function atividade(): BelongsTo
    {
        return $this->belongsTo(Atividade::class);
    }

    /**
     * Relacionamento 1xN: Atividade Designável tem várias Respostas.
     *
     * @return HasMany
     */
    public function respostas(): HasMany
    {
        return $this->hasMany(Resposta::class);
    }
}
