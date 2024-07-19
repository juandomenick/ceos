<?php

namespace App\Models\Academico\Questoes;

use App\Models\Academico\Atividade;
use App\Models\Academico\Habilidade;
use App\Models\Usuarios\Professor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Questao.
 *
 * @package namespace App\Models\Academico;
 */
class Questao extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'questoes';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'pontos',
        'tempo_minimo',
        'tempo_maximo',
        'ativo',
        'nivel',
        'tipo',
        'professor_id',
        'habilidade_id',
    ];

    /**
     * Relacionamento 1xN: Questão tem várias Alternativas.
     *
     * @return HasMany
     */
    public function alternativas(): HasMany
    {
        return $this->hasMany(Alternativa::class, '');
    }

    /**
     * Relacionamento 1xN: Questão tem várias Respostas.
     *
     * @return HasMany
     */
    public function respostas(): HasMany
    {
        return $this->hasMany(Resposta::class);
    }

    /**
     * Relacionamento Nx1: Questão pertence a um Professor.
     *
     * @return BelongsTo
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Relacionamento Nx1: Questão pertence a uma Habilidade.
     *
     * @return BelongsTo
     */
    public function habilidade(): BelongsTo
    {
        return $this->belongsTo(Habilidade::class);
    }

    /**
     * Relacionamento NxN: Questão pertence a várias Atividads.
     *
     * @return BelongsToMany
     */
    public function atividades(): BelongsToMany
    {
        return $this->belongsToMany(Atividade::class, 'atividade_questao', 'questao_id', 'atividade_id');
    }
}
