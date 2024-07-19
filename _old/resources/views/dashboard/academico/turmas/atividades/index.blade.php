@php
  $params = [
      'classesIcone' => 'fas fa-edit',
      'tituloPagina' => 'Atividades da Turma',
      'rotaVoltar' => ['turmas.edit', $turma->id],
  ];

  if (turmaPertenceAoProfessor($turma))
    $params += [
        'botaoAdd' => 'Atividade',
        'rotaAdd' => ['turmas.atividades.create', [$turma->id]],
    ];
@endphp

@extends('layouts.dashboard.index', $params)