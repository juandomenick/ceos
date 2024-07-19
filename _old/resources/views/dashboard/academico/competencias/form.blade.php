<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('descricao', 'Descrição:') !!}
      {!! Form::text('descricao', $competencia->descricao ?? old('descricao') ?? null, [
        'class' => 'form-control' . ($errors->has('descricao') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>

    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('ativo', 'Status:') !!}
      {!! Form::select('ativo', [true => 'Ativo', false => 'Inativo'], $competencia->ativo ?? old('ativo') ?? null, [
        'class' => 'form-control select2' . ($errors->has('ativo') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'ativo'])
    </div>
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<em class='fa fa-arrow-left'></em> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('competencias.index') . "'"
  ]) !!}

  {!! Form::button("<em class='fas fa-save mr-1'></em> Salvar", [
    'class' => 'btn btn-success float-right',
    'type' => 'submit'
  ]) !!}
</div>