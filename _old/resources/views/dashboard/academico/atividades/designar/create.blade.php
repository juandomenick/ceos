@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-project-diagram', 'tituloPagina' => 'Designar Atividade'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Designar Atividade</h5>
    </div>

    {!! Form::open(['route' => ['atividades.designar.store', $atividadeId], 'method' => 'POST']) !!}
      @include('dashboard.academico.atividades.designar.form')
    {!! Form::close() !!}
  </div>
@endsection