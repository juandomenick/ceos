@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-question', 'tituloPagina' => 'Questões'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Questão</h5>
    </div>

    {!! Form::open(['route' => ['questoes.store'], 'method' => 'POST']) !!}
      @include('dashboard.academico.questoes.form')
    {!! Form::close() !!}
  </div>
@endsection