<?php

use Illuminate\Support\Facades\Auth;

/**
 * Verifica se o usuário autenticado tem permissão para editar uma turma.
 *
 * @param $turma
 * @return bool
 */
function usuarioPodeAlterarTurma($turma): bool
{
    if (isset($turma->curso)) {
        return Auth::user()->hasRole('administrador') ||
            (Auth::user()->hasRole('diretor') && $turma->curso->instituicao->diretor_id == Auth::user()->id) ||
            (Auth::user()->hasRole('coordenador') && $turma->curso->coordenador_id == Auth::user()->coordenador->id) ||
            (Auth::user()->hasRole('professor') && $turma->professor_id == Auth::user()->professor->id);
    }

    if (isset($turma->codigo_proprietario)) {
        return $turma->codigo_proprietario == Auth::user()->google_id;
    }

    return true;
}

/**
 * Verifica se turma pertence ao professor autenticado.
 *
 * @param $turma
 * @return bool
 */
function turmaPertenceAoProfessor($turma): bool
{
    if (!Auth::user()->hasRole('professor') || !isset($turma)) {
        return false;
    }

    if (isset($turma->curso)) {
        return Auth::user()->hasRole('professor') && $turma->professor_id == Auth::user()->professor->id;
    }

    return $turma->codigo_proprietario == Auth::user()->google_id;
}