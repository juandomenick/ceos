<?php

namespace App\Models\Academico;

use App\Models\Academico\Questoes\Questao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Habilidade
 * @package App\Models\Academico
 */
class Habilidade extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'habilidades';

    /**
     * Atributos que são assinaláveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'descricao', 'sigla', 'ativo', 'nivel', 'competencia_id'
    ];

    /**
     * Relacionamento Nx1: Habilidade pertence a uma Competência.
     *
     * @return BelongsTo
     */
    public function competencia(): BelongsTo
    {
        return $this->belongsTo(Competencia::class);
    }

    /**
     * Relacionamento 1xN: Habilidade tem várias Questões.
     *
     * @return HasMany
     */
    public function questoes(): HasMany
    {
        return $this->hasMany(Questao::class);
    }
}
