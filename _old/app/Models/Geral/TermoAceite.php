<?php

namespace App\Models\Geral;

use Illuminate\Database\Eloquent\Model;

class TermoAceite extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'termos_aceite';

    /**
     * Atributos que são assinaláveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'titulo', 'descricao', 'ativo'
    ];
}
