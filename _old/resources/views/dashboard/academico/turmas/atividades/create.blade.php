@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-chalkboard-teacher', 'tituloPagina' => 'Turmas'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Atividade da Turma</h5>
    </div>

    {!! Form::open(['route' => ['turmas.atividades.store', $turma->id], 'method' => 'POST']) !!}
      @include('dashboard.academico.turmas.atividades.form')
    {!! Form::close() !!}
  </div>
@endsection