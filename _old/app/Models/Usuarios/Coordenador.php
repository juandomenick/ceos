<?php

namespace App\Models\Usuarios;

use App\Models\Academico\Curso;
use App\Models\Academico\Instituicao;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coordenador extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'coordenadores';

    /**
     * Atributos que são assinaláveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'instituicao_id', 'user_id'
    ];

    /**
     * Relacionamento 1x1: Coordenador é um Usuário.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento Nx1: Coordenador pertence a uma Instituição.
     *
     * @return BelongsTo
     */
    public function instituicao(): BelongsTo
    {
        return $this->belongsTo(Instituicao::class);
    }

    /**
     * Relacionamento 1xN: Coordenador tem vários Cursos.
     *
     * @return HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }
}
