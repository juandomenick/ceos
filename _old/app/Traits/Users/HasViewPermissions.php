<?php

namespace App\Traits\Users;

use App\Models\Academico\Questoes\Questao;
use Illuminate\Support\Facades\Auth;

/**
 * Trait HasViewPermissions
 *
 * @package App\Traits\Users
 */
trait HasViewPermissions
{
    /**
     * Verifica se o usuário autenticado pode criar uma questão.
     *
     * @param Questao|null $questao
     * @return bool
     */
    public function podeCriarQuestao(Questao $questao = null): bool
    {
        return !isset($questao) && Auth::user()->hasRole('professor');
    }

    /**
     * Verifica se o usuário autenticado pode atualizar uma questão.
     *
     * @param Questao|null $questao
     * @return bool
     */
    public function podeAtualizarQuestao(Questao $questao = null): bool
    {
        $usuario = Auth::user();
        $eProfessor = $usuario->hasRole('professor');
        $questaoPertenceAoProfessor = isset($questao) && $usuario->professor->id == $questao->professor_id;

        return $eProfessor && $questaoPertenceAoProfessor;
    }
}