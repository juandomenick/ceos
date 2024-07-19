<?php

namespace App\Models\Geral;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Cidade
 *
 * @package App\Models\Localizacao
 */
class Cidade extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'cidades';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = ['nome'];

    /**
     * Relacionamento Nx1: Cidade pertence a um Estado
     *
     * @return BelongsTo
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }
}
