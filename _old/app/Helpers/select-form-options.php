<?php

use Illuminate\Database\Eloquent\Collection;

/**
 * Retorna opções "Ativo" ou "Inativo"
 *
 * @return array
 */
function optionsAtivo(): array
{
    return [
        ['value' => '1', 'content' => 'Ativo'],
        ['value' => '0', 'content' => 'Inativo'],
    ];
}

/**
 * Retorna opções de Instituições passadas por parâmetro.
 *
 * @param Collection $instituicoes
 * @return array
 */
function optionsInstitituicao(Collection $instituicoes): array
{
    return $instituicoes->map(function ($instituicao) {
        return ['value' => $instituicao->id, 'content' => $instituicao->sigla];
    })->toArray();
}

/**
 * Retorna opções de Cursos passadas por parâmetro.
 *
 * @param Collection $cursos
 * @return array
 */
function optionsCursos(Collection $cursos): array
{
    return $cursos->map(function ($curso) {
        return ['value' => $curso->id, 'content' => $curso->nome];
    })->toArray();
}
/**
 * Retorna opções de status.
 *
 * @return array
 */
function selectStatus(): array
{
    return [
        '1' => 'Ativo',
        '0' => 'Inativo'
    ];
}

/**
 * Retorna opções de níveis.
 *
 * @return array
 */
function selectNiveis(): array
{
    return [
        'Fácil' => 'Fácil',
        'Intermediário' => 'Intermediário',
        'Difícil' => 'Difícil'
    ];
}

/**
 * Retorna opções de tipos de questões.
 *
 * @return array
 */
function selectTiposQuestao(): array
{
    return [
        'Alternativa' => 'Alternativa',
        'Complete' => 'Complete',
        'Dissertativa' => 'Dissertativa',
        'Ordenação' => 'Ordenação',
        'Quizz' => 'Quizz',
        'Sócio Econômico' => 'Sócio Econômico'
    ];
}