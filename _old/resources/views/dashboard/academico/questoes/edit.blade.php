@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-question', 'tituloPagina' => 'Questões'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Editar Questão</h5>
    </div>

    {!! Form::open(['route' => ['questoes.update', $questao->id], 'method' => 'PUT']) !!}
      @include('dashboard.academico.questoes.form')
    {!! Form::close() !!}
  </div>
@endsection