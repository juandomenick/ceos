@extends('dashboard.dashboard', ['classesIcone' => 'fab fa-stack-overflow', 'tituloPagina' => 'Habilidades'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Editar Habilidade</h5>
    </div>

    {!! Form::open(['route' => ['habilidades.update', $habilidade->id], 'method' => 'PUT']) !!}
      @include('dashboard.academico.habilidades.form')
    {!! Form::close() !!}
  </div>
@endsection