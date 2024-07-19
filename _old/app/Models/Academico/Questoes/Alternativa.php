<?php

namespace App\Models\Academico\Questoes;

use App\Models\Academico\Questoes\Questao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AlternativaQuestao
 *
 * @package App\Models\Academico
 */
class Alternativa extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'alternativas_questoes';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'questao_id',
        'descricao',
        'alternativa_correta',
    ];

    /**
     * Relacionamento Nx1: Alternativa pertence a uma Questão.
     *
     * @return BelongsTo
     */
    public function questao(): BelongsTo
    {
        return $this->belongsTo(Questao::class);
    }

    /**
     * Mutator - Retorna o atributo 'alterntativa correta' formatado.
     *
     * @return string
     */
    public function getAlternativaCorretaFormatadoAttribute(): string
    {
        return $this->alternativa_correta ? 'Sim' : 'Não';
    }
}
