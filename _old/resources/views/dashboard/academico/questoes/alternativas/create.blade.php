@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-question', 'tituloPagina' => 'Questões - Alternativas'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Alternativa</h5>
    </div>

    {!! Form::open(['route' => ['questoes.alternativas.store', $questao], 'method' => 'POST']) !!}
      @include('dashboard.academico.questoes.alternativas.form')
    {!! Form::close() !!}
  </div>
@endsection