@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-edit', 'tituloPagina' => 'Atividades'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Atividade</h5>
    </div>

    {!! Form::open(['route' => ['atividades.store'], 'method' => 'POST']) !!}
    @include('dashboard.academico.atividades.form')
    {!! Form::close() !!}
  </div>
@endsection