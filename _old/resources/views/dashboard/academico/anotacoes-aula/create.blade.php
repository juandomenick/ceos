@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-tasks', 'tituloPagina' => 'Anotações de Aula'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Anotação</h5>
    </div>

    {!! Form::open(['route' => ['anotacoes-aula.store'], 'method' => 'POST']) !!}
      @include('dashboard.academico.anotacoes-aula.form')
    {!! Form::close() !!}
  </div>
@endsection