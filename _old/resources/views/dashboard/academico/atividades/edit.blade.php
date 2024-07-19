@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-edit', 'tituloPagina' => 'Atividades'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Editar Atividade</h5>
    </div>

    {!! Form::open(['route' => ['atividades.update', $atividade->id], 'method' => 'PUT']) !!}
      @include('dashboard.academico.atividades.form')
    {!! Form::close() !!}
  </div>
@endsection