<?php

namespace App\Models\Geral;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Estado
 *
 * @package App\Models\Localizacao
 */
class Estado extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'estados';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'uf', 'nome'
    ];

    /**
     * Relacionamento 1xN: Estado tem várias Cidades
     *
     * @return HasMany
     */
    public function cidades(): HasMany
    {
        return $this->hasMany(Cidade::class);
    }
}
