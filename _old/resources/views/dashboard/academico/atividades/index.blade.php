@php
  $params = ['classesIcone' => 'fas fa-edit', 'tituloPagina' => 'Atividades'];

  if (auth()->user()->hasRole('professor'))
    $params += ['botaoAdd' => 'Atividade', 'rotaAdd' => 'atividades.create'];
@endphp

@extends('layouts.dashboard.index', $params)