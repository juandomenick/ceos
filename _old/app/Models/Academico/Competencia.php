<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Competencia
 *
 * @package App\Models\Academico
 */
class Competencia extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'competencias';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'descricao', 'ativo'
    ];

    /**
     * Relacionamento Nx1: Competência pertence a várias Habilidades.
     *
     * @return HasMany
     */
    public function habilidades(): HasMany
    {
        return $this->hasMany(Habilidade::class);
    }
}
