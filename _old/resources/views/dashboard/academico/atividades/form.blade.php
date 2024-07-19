{!! Form::hidden('professor_id', auth()->user()->professor->id ?? null) !!}

<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="form-group col-md-12 col-lg-3 form-group">
      {!! Form::label('disciplina_id', 'Disciplina:') !!}
      {!! Form::select('disciplina_id', $disciplinas, $atividade->disciplina->id ?? old('disciplina_id'), [
        'class' => 'form-control select2' . ($errors->has('disciplina_id') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'disciplina_id'])
    </div>

    <div class="col-md-12 col-lg-3 form-group">
      {!! Form::label('tipo', 'Tipo:') !!}
      {!! Form::select('tipo', [
          'Avaliação Impressa' => 'Avaliação Impressa',
          'Questionário' => 'Questionário',
          'Simulado' => 'Simulado'
        ], $atividade->tipo ?? old('tipo'), [
          'class' => 'form-control select2'
        ]
      )!!}
    </div>

    <div class="col-md-12 col-lg-3 form-group">
      {!! Form::label('nivel', 'Nível:') !!}
      {!! Form::select('nivel', [
          'Iniciante' => 'Iniciante',
          'Inteligência Múltiplas' => 'Inteligência Múltiplas',
          'Sócio Econômico - Adulto' => 'Sócio Econômico - Adulto',
          'Sócio Ecoômico - Infantil' => 'Sócio Ecoômico - Infantil'
        ], $atividade->nivel ?? old('nivel'), [
          'class' => 'form-control select2'
        ]
      )!!}
    </div>

    <div class="col-md-12 col-lg-3 form-group">
      {!! Form::label('visualizacao', 'Visualização:') !!}
      {!! Form::select('visualizacao', [
          'Total' => 'Total',
          'Individual' => 'Individual'
        ], $atividade->visualizacao ?? old('visualizacao'), [
          'class' => 'form-control select2'
        ]
      )!!}
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-lg-3 form-group">
      {!! Form::label('pontos', 'Pontos:') !!}
      {!! Form::number('pontos', $atividade->pontos ?? old('pontos'), [
        'class' => 'form-control' . ($errors->has('pontos') ? ' is-invalid' : '' ),
        'min' => '1'
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'pontos'])
    </div>

    <div class="col-md-12 col-lg-3 form-group">
      {!! Form::label('tempo_minimo', 'Tempo Mínimo:') !!}
      {!! Form::number('tempo_minimo', $atividade->tempo_minimo ?? old('tempo_minimo'), [
        'class' => 'form-control' . ($errors->has('tempo_minimo') ? ' is-invalid' : '' ),
        'min' => '1'
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'tempo_minimo'])
    </div>

    <div class="col-md-12 col-lg-3 form-group">
      {!! Form::label('tempo_maximo', 'Tempo Máximo:') !!}
      {!! Form::number('tempo_maximo', $atividade->tempo_maximo ?? old('tempo_maximo'), [
        'class' => 'form-control' . ($errors->has('tempo_maximo') ? ' is-invalid' : '' ),
        'min' => '1'
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'tempo_maximo'])
    </div>

    <div class="col-md-12 col-lg-3 form-group">
      {!! Form::label('ativo', 'Status:') !!}
      {!! Form::select('ativo', [
          true => 'Ativo',
          false => 'Inativo'
        ], $atividade->ativo ?? old('ativo'), [
          'class' => 'form-control select2'
        ]
      )!!}
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('metodo_avaliacao', 'Método de Avaliação:') !!}
      {!! Form::textarea('metodo_avaliacao', $atividade->metodo_avaliacao ?? old('metodo_avaliacao'), [
        'class' => 'form-control' . ($errors->has('metodo_avaliacao') ? ' is-invalid' : '' ),
        'rows' => 3
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'metodo_avaliacao'])
    </div>

    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('descricao', 'Descrição:') !!}
      {!! Form::textarea('descricao', $atividade->descricao ?? old('descricao'), [
        'class' => 'form-control' . ($errors->has('descricao') ? ' is-invalid' : '' ),
        'rows' => 3
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>
  </div>

  <div class="row">
    <div class="form-group col-12">
      {!! Form::label('questoes', 'Questões:') !!}
      {!! Form::select('questoes[]', $questoes, isset($atividade) ? $atividade->questoes->map(function ($questao) { return $questao->id; }) : [], [
        'class' => 'form-control select2 js-example-basic-multiple',
        'multiple' => true,
      ]) !!}
    </div>
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<i class='fa fa-arrow-left'></i> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('atividades.index') . "'"
  ]) !!}

  {!! Form::button("<i class='fas fa-save mr-1'></i> Salvar", [
    'class' => 'btn btn-success float-right',
    'type' => 'submit',
    'disabled' => !auth()->user()->hasRole('professor') || (isset($atividade) && auth()->user()->professor->id != $atividade->professor_id)
  ]) !!}
</div>

@push('scripts')
  <script src="{{ asset('js/views/dashboard/academico/atividades/nova-atividade.js') }}"></script>
  <script>
    $(document).ready(function () {
      onChangeInstituicao('{{ $atividade->disciplina->curso->id ??  old('curso') }}', '{{ $atividade->disciplina->id ?? old('disciplina') }}');
    });
  </script>
@endpush