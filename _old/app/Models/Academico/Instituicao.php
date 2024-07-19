<?php

namespace App\Models\Academico;

use App\Models\Geral\Cidade;
use App\Models\Usuarios\Coordenador;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Instituicao
 *
 * @package App\Models\Academico
 */
class Instituicao extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'instituicoes';

    /**
     * Atributos que são assinaláveis em massa
     *
     * @var array
     */
    protected $fillable = [
        'cidade_id',
        'diretor_id',
        'nome',
        'sigla',
        'telefone',
        'ativo',
    ];

    /**
     * Relacionamento Nx1: Instituição pertence a um Usuário (Diretor)
     *
     * @return BelongsTo
     */
    public function diretor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diretor_id');
    }

    /**
     * Relacionamento 1xN: Instituição tem vários Usuários (Coordenador).
     *
     * @return HasMany
     */
    public function coordenadores(): HasMany
    {
        return $this->hasMany(Coordenador::class);
    }

    /**
     * Relacionamento 1xN: Instituição tem vários Cursos.
     *
     * @return HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }

    /**
     * Relacionamento Nx1: Instituição pertence a uma Cidade
     *
     * @return BelongsTo
     */
    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }
}
