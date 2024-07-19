<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('nome', 'Nome:') !!}
      {!! Form::text('nome', $equipe->nome ?? old('nome') ?? null, [
        'class' => 'form-control' . ($errors->has('nome') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'nome'])
    </div>

    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('data_formacao', 'Data de formação:') !!}
      {!! Form::date('data_formacao', $equipe->data_formacao ?? old('data_formacao') ?? null, [
        'class' => 'form-control' . ($errors->has('data_formacao') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'data_formacao'])
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('ativo', 'Status:') !!}
      {!! Form::select('ativo', [true => 'Ativo', false => 'Inativo'], $equipe->ativo ?? old('ativo') ?? null, [
        'class' => 'form-control select2' . ($errors->has('ativo') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'ativo'])
    </div>

    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('turma_id', 'Turma:') !!}
      {!! Form::select('turma_id', $turmas, $equipe->turma->id ?? old('turma') ?? null, [
        'class' => 'form-control select2' . ($errors->has('turma_id') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'turma_id'])
    </div>
  </div>

  <div class="row">
    <div class="form-group col-12">
      {!! Form::label('alunos', 'Alunos:') !!}
      {!! Form::select('alunos[]', $alunos, isset($equipe) ? $equipe->alunos->pluck('id') : [], [
        'class' => 'form-control select2 js-example-basic-multiple',
        'multiple' => true,
      ]) !!}
    </div>
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<em class='fa fa-arrow-left'></em> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('equipes.index') . "'"
  ]) !!}

  {!! Form::button("<em class='fas fa-save mr-1'></em> Salvar", [
    'class' => 'btn btn-success float-right',
    'type' => 'submit'
  ]) !!}
</div>