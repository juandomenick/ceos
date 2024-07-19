<?php

namespace App\Models\Academico;

use App\Models\Academico\Questoes\Questao;
use App\Models\Usuarios\Professor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atividade extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'atividades';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'professor_id',
        'disciplina_id',
        'tipo',
        'nivel',
        'visualizacao',
        'pontos',
        'tempo_minimo',
        'tempo_maximo',
        'metodo_avaliacao',
        'descricao',
        'ativo',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'ativo' => 'bool',
    ];

    /**
     * Relacionamento Nx1: Atividade pertence a um Professor.
     *
     * @return BelongsTo
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }


    /**
     * Relacionamento Nx1: Atividade pertence a uma Disciplina.
     *
     * @return BelongsTo
     */
    public function disciplina(): BelongsTo
    {
        return $this->belongsTo(Disciplina::class);
    }

    /**
     * Relacionamento NxN: Questão pertence a várias Atividads.
     *
     * @return BelongsToMany
     */
    public function questoes(): BelongsToMany
    {
        return $this->belongsToMany(Questao::class, 'atividade_questao', 'atividade_id', 'questao_id');
    }

    /**
     * Relacionamento 1xN: Atividade pode ser designável.
     *
     * @return HasMany
     */
    public function atividadesDesignaveis(): HasMany
    {
        return $this->hasMany(AtividadeDesignavel::class);
    }
}
