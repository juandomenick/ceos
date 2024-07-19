<?php

function calcularIdade($dataNascimento)
{
    $dataNascimento = new \DateTime($dataNascimento);
    $dataAtual = new \DateTime(date('Y-m-d'));

    return $dataNascimento->diff($dataAtual)->format('%Y');
}

function eMaiorDeIdade($dataNascimento)
{
    return calcularIdade($dataNascimento) >= 18;
}

function eMenorDeIdade($dataNascimento)
{
    return calcularIdade($dataNascimento) < 18;
}