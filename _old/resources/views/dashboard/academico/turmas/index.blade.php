@php
  $params = ['classesIcone' => 'fas fa-chalkboard-teacher', 'tituloPagina' => 'Turmas'];

  if (auth()->user()->hasRole('administrador|diretor|coordenador')) {
      $params += ['botaoAdd' => 'Turma', 'rotaAdd' => 'turmas.create'];
  }
@endphp

@extends('layouts.dashboard.index', $params)