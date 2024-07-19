{!! Form::hidden('professor_id', auth()->user()->professor->id ?? null) !!}

<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="form-group col-12">
      {!! Form::label('titulo', 'Título:') !!}
      {!! Form::text('titulo', $questao->titulo ?? old('titulo'), [
        'class' => 'form-control' . ($errors->has('titulo') ? ' is-invalid' : '' )
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'titulo'])
    </div>
  </div>

  <div class="row">
    <div class="form-group col-12">
      {!! Form::label('descricao', 'Descrição:') !!}
      {!! Form::textarea('descricao', $questao->descricao ?? null, [
        'class' => 'form-control summernote' . ($errors->has('descricao') ? ' is-invalid' : '' ),
        'rows' => 5
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>
  </div>

  <div class="row">
    <div class="form-group col-6">
      {!! Form::label('habilidade_id', 'Habilidade:') !!}
      {!! Form::select('habilidade_id', $habilidades, $questao->habilidade_id ?? null, [
        'class' => 'form-control select2'
      ]) !!}
    </div>

    <div class="form-group col-md-12 col-lg-6">
      {!! Form::label('tipo', 'Tipo:') !!}
      {!! Form::select('tipo', selectTiposQuestao(), $questao->tipo ?? null, [
        'class' => 'form-control select2'
      ]) !!}
    </div>
  </div>

  <div class="row">
    <div class="form-group col-md-12 col-lg-6">
      {!! Form::label('nivel', 'Nível:') !!}
      {!! Form::select('nivel', selectNiveis(), $questao->nivel ?? null, [
        'class' => 'form-control select2'
      ]) !!}
    </div>

    <div class="form-group col-md-12 col-lg-6">
      {!! Form::label('ativo', 'Status:') !!}
      {!! Form::select('ativo', selectStatus(), $questao->ativo ?? null, [
        'class' => 'form-control select2'
      ]) !!}
    </div>
  </div>

  <div class="row">
    <div class="form-group col-md-12 col-lg-4">
      {!! Form::label('pontos', 'Pontos:') !!}
      {!! Form::number('pontos', $questao->pontos ?? null, [
        'class' => 'form-control' . ($errors->has('pontos') ? ' is-invalid' : '' ),
        'min' => 0
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'pontos'])
    </div>

    <div class="form-group col-md-12 col-lg-4">
      {!! Form::label('tempo_minimo', 'Tempo Mínimo:') !!}
      {!! Form::number('tempo_minimo', $questao->tempo_minimo ?? null, [
        'class' => 'form-control' . ($errors->has('tempo_minimo') ? ' is-invalid' : '' ),
        'min' => 1,
        'max' => 60
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'tempo_minimo'])
    </div>

    <div class="form-group col-md-12 col-lg-4">
      {!! Form::label('tempo_maximo', 'Tempo Máximo:') !!}
      {!! Form::number('tempo_maximo', $questao->tempo_maximo ?? null, [
        'class' => 'form-control' . ($errors->has('tempo_maximo') ? ' is-invalid' : '' ),
        'min' => 1,
        'max' => 60
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'tempo_maximo'])
    </div>
  </div>

  @if (isset($questao) && $questao->tipo === 'Alternativa')
    <div class="row">
      <div class="col-12">
        <hr>

        <fieldset>
          <legend>
            <span>Alternativas</span>

            @if (auth()->user()->podeCriarQuestao($questao ?? null) || auth()->user()->podeAtualizarQuestao($questao ?? null))
              <a href="{{ route('questoes.alternativas.create', $questao->id) }}" class="btn btn-secondary float-right">
                <i class='fas fa-plus mr-1'></i> Alternativa
              </a>
            @endif
          </legend>

          <div class="mt-3">
            <table class="table">
              <thread>
                <tr>
                  <th>Descrição</th>
                  <th>Alternativa Correta</th>
                  <th>Ações</th>
                </tr>
              </thread>

              <tbody>
                @forelse ($questao->alternativas as $alternativa)
                  <tr>
                    <td>{!! $alternativa->descricao !!}</td>
                    <td>{{ $alternativa->alternativa_correta_formatado }}</td>
                    <td>
                      <div class='btn-group'>
                        <a href="{{ route('questoes.alternativas.edit', [$questao->id, $alternativa->id]) }}"
                           class='btn btn-info {{ auth()->user()->podeCriarQuestao($questao ?? null) || auth()->user()->podeAtualizarQuestao($questao ?? null) ?: 'disabled'}}'>
                          <i class="fa fa-edit m-0 p-0"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3">Nenhuma alterativa vinculada a esta questão.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </fieldset>
      </div>
    </div>
  @endif
</div>

<div class="card-footer">
  {!! Form::button("<i class='fa fa-arrow-left'></i> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('questoes.index') . "'"
  ]) !!}

  @if (auth()->user()->podeCriarQuestao($questao ?? null) || auth()->user()->podeAtualizarQuestao($questao ?? null))
    {!! Form::button("<i class='fas fa-save mr-1'></i> Salvar", [
        'class' => 'btn btn-success float-right',
        'type' => 'submit'
    ]) !!}
  @endif
</div>