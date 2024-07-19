{!! Form::hidden('professor_id', auth()->user()->professor->id ?? null) !!}

<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('aluno', 'Aluno:') !!}
      {!! Form::text('aluno', $anotacao->aluno ?? old('aluno') ?? null, [
        'class' => 'form-control' . ($errors->has('aluno') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'aluno'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('descricao', 'Descrição:') !!}
      {!! Form::text('descricao', $anotacao->descricao ?? old('descricao') ?? null, [
        'class' => 'form-control' . ($errors->has('descricao') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('turma_id', 'Turma:') !!}
      {!! Form::select('turma_id', $turmas, $anotacao->turma->id ?? old('turma') ?? null, [
        'class' => 'form-control select2' . ($errors->has('turma_id') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'turma_id'])
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('data', 'Data:') !!}
      {!! Form::date('data', $anotacao->data ?? old('data') ?? null, [
        'class' => 'form-control' . ($errors->has('data') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'data'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('hora', 'Hora:') !!}
      {!! Form::time('hora', $anotacao->hora ?? old('hora') ?? null, [
        'class' => 'form-control' . ($errors->has('hora') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'hora'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('assinatura', 'Assinatura:') !!}
      {!! Form::text('assinatura', $anotacao->assinatura ?? old('assinatura') ?? null, [
        'class' => 'form-control' . ($errors->has('assinatura') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'assinatura'])
    </div>
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<i class='fa fa-arrow-left'></i> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('anotacoes-aula.index') . "'"
  ]) !!}

  {!! Form::button("<i class='fas fa-save mr-1'></i> Salvar", [
    'class' => 'btn btn-success float-right',
    'type' => 'submit'
  ]) !!}
</div>