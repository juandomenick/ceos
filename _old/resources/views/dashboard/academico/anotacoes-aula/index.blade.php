@php
  $params = ['classesIcone' => 'fas fa-tasks', 'tituloPagina' => 'Anotações de Aula'];

  if (auth()->user()->hasRole('professor'))
    $params += ['botaoAdd' => 'Anotação', 'rotaAdd' => 'anotacoes-aula.create'];
@endphp

@extends('layouts.dashboard.index', $params)