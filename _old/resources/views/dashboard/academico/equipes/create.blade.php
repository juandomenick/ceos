@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-users', 'tituloPagina' => 'Equipes'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Equipe</h5>
    </div>

    {!! Form::open(['route' => ['equipes.store'], 'method' => 'POST']) !!}
      @include('dashboard.academico.equipes.form')
    {!! Form::close() !!}
  </div>
@endsection