@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-chalkboard-teacher', 'tituloPagina' => 'Turmas'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Turma</h5>
    </div>

    {!! Form::open(['route' => ['turmas.store'], 'method' => 'POST']) !!}
      @include('dashboard.academico.turmas.form')
    {!! Form::close() !!}
  </div>
@endsection