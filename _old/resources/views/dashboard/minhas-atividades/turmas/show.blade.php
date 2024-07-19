@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-chalkboard-teacher', 'tituloPagina' => 'Atividades Turmas'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Visualizar Atividade</h5>
    </div>

    {!! Form::open(['route' => ['atividades.respostas', $atividade->id], 'method' => 'POST']) !!}
      {!! Form::hidden('atividade_id', $atividade->id) !!}
      {!! Form::hidden('aluno_id', auth()->user()->aluno->id ?? null) !!}

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          <div class="col-12">
            <h1 class="mb-4">{{ $atividade->descricao }}</h1>
          </div>
        </div>

        @foreach ($atividade->atividade->questoes as $questao)
          <div class="row">
            <div class="col-12">
              <h3>{{ $questao->titulo }}</h3>
              <p>{!! $questao->descricao !!}</p>
            </div>

            <div class="col-12 mb-3">
              @if ($questao->tipo === 'Alternativa')
                @foreach ($questao->alternativas as $alternativa)
                  @php
                    $cssClass = $disabled = $checked = '';
                    $resposta = $questao->respostas[0] ?? false;
                    $alternativa = $alternativa ?? null;

                    if ($resposta) {
                      $cssClass = '';
                      $disabled = $resposta || !auth()->user()->hasRole('aluno') ? 'disabled' : '';
                      $checked = $resposta->resposta == $alternativa->id ? 'checked' : '';

                      if ($resposta->resposta == $alternativa->id) {
                          $cssClass = $resposta->resposta_correta ? 'is-valid' : 'is-invalid';
                      }else if ($alternativa->alternativa_correta) {
                          $cssClass = 'is-valid';
                      }
                    }
                  @endphp

                  <div class="form-check">
                    <input class="form-check-input {{ $cssClass }}" type="radio" name="questoes[{{ $questao->id }}]"
                           id="{{ $alternativa->id }}" value="{{ $alternativa->id }}" {{ $disabled }} {{ $checked }}>
                    <label class="form-check-label" for="{{ $alternativa->id }}">
                      {!! $alternativa->descricao !!}
                    </label>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        @endforeach
      </div>

      <div class="card-footer">
        <a href="{{ route('atividades-individuais.index') }}" class="btn btn-primary">
          <em class='fa fa-arrow-left'></em> Voltar
        </a>

        @hasrole('aluno')
        <button type="submit" class="btn btn-success float-right" @if ($atividade->respondida) disabled @endif>
          <em class='fa fa-save'></em> Responder
        </button>
        @endhasrole
      </div>
    {!! Form::close() !!}
  </div>
@endsection