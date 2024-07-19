@php
  $params = ['classesIcone' => 'fa fa-question', 'tituloPagina' => 'Questões'];

  if (auth()->user()->hasRole('professor'))
    $params += ['botaoAdd' => 'Questão', 'rotaAdd' => 'questoes.create'];
@endphp

@extends('layouts.dashboard.index', $params)