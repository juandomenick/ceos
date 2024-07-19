@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-network-wired', 'tituloPagina' => 'Competências'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Editar Competência</h5>
    </div>

    {!! Form::open(['route' => ['competencias.update', $competencia->id], 'method' => 'PUT']) !!}
      @include('dashboard.academico.competencias.form')
    {!! Form::close() !!}
  </div>
@endsection