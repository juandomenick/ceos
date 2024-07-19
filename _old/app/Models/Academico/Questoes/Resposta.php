<?php

namespace App\Models\Academico\Questoes;

use App\Models\Academico\AtividadeDesignavel;
use App\Models\Usuarios\Aluno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Resposta
 *
 * @package App\Models\Academico\Questoes
 */
class Resposta extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'respostas';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'atividade_designada_id',
        'questao_id',
        'aluno_id',
        'resposta',
        'resposta_correta',
    ];

    /**
     * Casts de atributos.
     *
     * @var string[]
     */
    protected $casts = [
        'resposta_correta' => 'bool'
    ];

    /**
     * Relacionamento Nx1: Resposta pertence a um Atividade.
     *
     * @return BelongsTo
     */
    public function atividade(): BelongsTo
    {
        return $this->belongsTo(AtividadeDesignavel::class);
    }

    /**
     * Relacionamento Nx1: Resposta pertence a um Questão.
     *
     * @return BelongsTo
     */
    public function questao(): BelongsTo
    {
        return $this->belongsTo(Questao::class);
    }

    /**
     * Relacionamento Nx1: Resposta pertence a um Aluno.
     *
     * @return BelongsTo
     */
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class);
    }
}
