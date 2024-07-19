<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="col-md-12 col-lg-8 form-group">
      {!! Form::label('descricao', 'Descrição:') !!}
      {!! Form::text('descricao', $habilidade->descricao ?? old('descricao') ?? null, [
        'class' => 'form-control' . ($errors->has('descricao') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('sigla', 'Sigla:') !!}
      {!! Form::text('sigla', $habilidade->sigla ?? old('sigla') ?? null, [
        'class' => 'form-control' . ($errors->has('sigla') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'sigla'])
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('nivel', 'Nivel:') !!}
      {!! Form::select('nivel', ['Fácil' => 'Fácil', 'Intermediário' => 'Intermediário', 'Difícil' => 'Difícil'], $habilidade->nivel ?? old('nivel') ?? null, [
        'class' => 'form-control select2' . ($errors->has('nivel') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'nivel'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('competencia_id', 'Competência:') !!}
      {!! Form::select('competencia_id', $competencias, $habilidade->competencia_id ?? old('competencia_id') ?? null, [
        'class' => 'form-control select2' . ($errors->has('competencia_id') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'competencia_id'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('ativo', 'Status:') !!}
      {!! Form::select('ativo', [true => 'Ativo', false => 'Inativo'], $habilidade->ativo ?? old('ativo') ?? null, [
        'class' => 'form-control select2' . ($errors->has('ativo') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'ativo'])
    </div>
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<em class='fa fa-arrow-left'></em> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('habilidades.index') . "'"
  ]) !!}

  {!! Form::button("<em class='fas fa-save mr-1'></em> Salvar", [
    'class' => 'btn btn-success float-right',
    'type' => 'submit'
  ]) !!}
</div>