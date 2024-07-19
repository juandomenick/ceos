{!! Form::hidden('questao_id', $questao->id) !!}

<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="form-group col-12">
      {!! Form::label('descricao', 'Descrição:') !!}
      {!! Form::textarea('descricao', $alternativa->descricao ?? false, [
        'class' => 'form-control summernote' . ($errors->has('descricao') ? ' is-invalid' : '' ),
        'rows' => 5
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="form-check">
        {!! Form::checkbox('alternativa_correta', true, $alternativa->alternativa_correta ?? null, [
          'class' => 'form-check-input',
          'id' => 'alternativa-correta'
        ]) !!}
        {!! Form::label('alternativa-correta', 'Alternativa Correta', ['class' => 'form-check-label']) !!}
      </div>
    </div>
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<i class='fa fa-arrow-left'></i> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('questoes.edit', $questao->id) . "'"
  ]) !!}

  {!! Form::button("<i class='fas fa-save mr-1'></i> Salvar", [
      'class' => 'btn btn-success float-right',
      'type' => 'submit'
  ]) !!}
</div>