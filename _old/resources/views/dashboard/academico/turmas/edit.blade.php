@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-chalkboard-teacher', 'tituloPagina' => 'Turmas'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header d-flex justify-content-between align-content-center">
      <div>
        <h5 class="m-0">Editar Turma</h5>

        <span>
          @isset ($turma->link_sala)
            <a href="{{ $turma->link_sala }}" target="_blank">Ir para Classroom</a>
          @endisset
        </span>
      </div>

      <a href="{{ route('turmas.atividades.index', $turma->id) }}" class="btn btn-primary">
        Atividades
      </a>
    </div>

    {!! Form::open(['route' => ['turmas.update', $turma->id], 'method' => 'PUT']) !!}
      @include('dashboard.academico.turmas.form')
    {!! Form::close() !!}
  </div>
@endsection