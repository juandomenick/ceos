@extends('dashboard.dashboard', ['classesIcone' => 'fab fa-stack-overflow', 'tituloPagina' => 'Habilidades'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Nova Habilidade</h5>
    </div>

    {!! Form::open(['route' => ['habilidades.store'], 'method' => 'POST']) !!}
      @include('dashboard.academico.habilidades.form')
    {!! Form::close() !!}
  </div>
@endsection