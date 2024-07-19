@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-question', 'tituloPagina' => 'Questões - Alternativas'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h5 class="align-self-center m-0">Editar Alternativa</h5>

      {!! Form::button('<i class="fa fa-trash mr-1"></i> Deletar', [
          'type' => 'submit',
          'class' => 'btn btn-danger',
          'onclick' => "deletarRecurso('" . csrf_token() . "', '" . route('questoes.alternativas.destroy', [$questao, $alternativa->id]) . "', 'Alternativa')"
      ]) !!}
    </div>

    {!! Form::open(['route' => ['questoes.alternativas.update', $questao, $alternativa->id], 'method' => 'PUT']) !!}
      @include('dashboard.academico.questoes.alternativas.form')
    {!! Form::close() !!}
  </div>
@endsection