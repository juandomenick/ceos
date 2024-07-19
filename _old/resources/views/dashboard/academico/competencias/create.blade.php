@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-network-wired', 'tituloPagina' => 'Competências'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Competência</h5>
    </div>

    {!! Form::open(['route' => ['competencias.store'], 'method' => 'POST']) !!}
      @include('dashboard.academico.competencias.form')
    {!! Form::close() !!}
  </div>
@endsection