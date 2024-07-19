<div class="card-body">
  @include('layouts.geral.alert')

  {!! Form::hidden('professor_id', auth()->user()->professor ? auth()->user()->professor->id : null) !!}
  {!! Form::hidden('turma_id', $turma->id) !!}

  <div class="row">
    <div class="form-group col-12">
      {!! Form::label('titulo', 'Titulo:') !!}
      {!! Form::text('titulo', $atividade->titulo ?? null, [
        'class' => 'form-control' . ($errors->has('titulo') ? ' is-invalid' : '')
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'titulo'])
    </div>

    <div class="form-group col-12">
      {!! Form::label('descricao', 'Instruções:') !!}
      {!! Form::textarea('descricao', $atividade->descricao ?? null, [
        'class' => 'form-control' . ($errors->has('descricao') ? ' is-invalid' : '' ),
        'rows' => 3,
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>
  </div>

  <div class="row justify-content-between">
    <div class="form-group flex-fill mr-3 ml-3">
      {!! Form::label('pontos', 'Pontos:') !!}
      {!! Form::text('pontos', $atividade->pontos ?? null, [
        'class' => 'form-control' . ($errors->has('pontos') ? ' is-invalid' : '')
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'pontos'])
    </div>

    <div class="form-group flex-fill mr-3 ml-3">
      {!! Form::label('data_entrega', 'Data Entrega:') !!}
      <input type="datetime-local" name="data_entrega" id="data_entrega"
             class="form-control {{ $errors->has('data_entrega') ? ' is-invalid' : '' }}"
             value="{{ $atividade->data_entrega ?? old('data_entrega') ?? null }}">
      @include('layouts.forms.form-error', ['nomeCampo' => 'data_entrega'])
    </div>

    @if (isset($atividade) && isset($atividade->professor_id) && auth()->user()->hasrole('professor'))
      <div class="form-group flex-fill mr-3 ml-3">
        {!! Form::label('ativo', 'Status:') !!}
        {!! Form::select('ativo', [true => 'Ativo', false => 'Inativo'], $atividade->ativo ?? old('ativo'), [
          'class' => 'form-control select2'
        ])!!}
      </div>
    @endif
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<em class='fa fa-arrow-left'></em> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('turmas.atividades.index', $turma->id) . "'"
  ]) !!}

  @if (turmaPertenceAoProfessor($turma))
    {!! Form::button("<em class='fas fa-save mr-1'></em> Salvar", [
      'class' => 'btn btn-success float-right',
      'type' => 'submit'
    ]) !!}
  @endif
</div>
