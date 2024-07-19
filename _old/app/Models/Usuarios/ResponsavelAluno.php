<?php

namespace App\Models\Usuarios;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ResponsavelAluno
 *
 * @package App\Models\Usuarios
 */
class ResponsavelAluno extends Model
{
    /**
     * Nome da tabela correspondente ao modelo.
     *
     * @var string
     */
    protected $table = 'responsavel_alunos';

    /**
     * Relacionamento 1x1: Responsável é um Usuário.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento 1xN: Responsável tem vários Alunos.
     *
     * @return HasMany
     */
    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class);
    }
}
