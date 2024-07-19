@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-sign-in-alt', 'tituloPagina' => 'Ingressar em Turma'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Ingresso em Turma</h5>
    </div>

    {!! Form::open(['route' => ['turmas.ingresso.store'], 'method' => 'POST']) !!}
      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          <div class="col-12 form-group">
            {!! Form::label('codigo-turma', 'Código da Turma:') !!}
            {!! Form::text('codigo', old('codigo') ?? null, [
              'class' => 'form-control' . ($errors->has('codigo') ? ' is-invalid' : '' )
            ]) !!}
            @include('layouts.forms.form-error', ['nomeCampo' => 'codigo'])
          </div>
        </div>
      </div>

      <div class="card-footer">
        {!! Form::submit('Ingressar', ['class' => 'btn btn-primary float-right']) !!}
      </div>
    {!! Form::close() !!}
  </div>
@endsection