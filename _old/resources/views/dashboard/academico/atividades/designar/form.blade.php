{!! Form::hidden('atividade_id', $atividadeId) !!}

<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row">
    <div class="col-md-12 col-lg-6 form-group">
      {!! Form::label('designar_para', 'Desingar Para:') !!}
      {!! Form::select('designar_para', ['turma' => 'Turma', 'equipe' => 'Equipe', 'aluno' => 'Aluno'], old('designar_para') ?? null, [
        'class' => 'form-control select2',
        'onchange' => 'onChangeDesignarPara()'
      ]) !!}
    </div>

    <div class="col-md-12 col-lg-6 form-group" id="turmas">
      {!! Form::label('turma_id', 'Turma:') !!}
      {!! Form::select('turma_id', $turmas, $atividadeDesignada->atividade_designavel_id ?? old('turma_id') ?? null, [
        'class' => 'form-control select2' . ($errors->has('turma_id') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'turma_id'])
    </div>

    <div class="col-md-12 col-lg-6 form-group" id="equipes">
      {!! Form::label('equipe_id', 'Equipe:') !!}
      {!! Form::select('equipe_id', $equipes, $atividadeDesignada->atividade_designavel_id ?? old('equipe_id') ?? null, [
        'class' => 'form-control select2' . ($errors->has('equipe_id') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'equipe_id'])
    </div>

    <div class="col-md-12 col-lg-6 form-group" id="alunos">
      {!! Form::label('aluno_id', 'Aluno:') !!}
      {!! Form::select('aluno_id', $alunos, $atividadeDesignada->atividade_designavel_id ?? old('aluno_id') ?? null, [
        'class' => 'form-control select2' . ($errors->has('aluno_id') ? ' is-invalid' : '' ),
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'aluno_id'])
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('pontos', 'Pontos') !!}
      {!! Form::number('pontos', $atividadeDesignada->pontos ?? old('pontos') ?? null, [
        'class' => 'form-control' . ($errors->has('pontos') ? ' is-invalid' : '' ),
        'min' => 0,
        'placeholder' => 'Pontos'
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'pontos'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('tempo', 'Tempo (min):') !!}
      {!! Form::number('tempo', $atividadeDesignada->tempo ?? old('tempo') ?? null, [
        'class' => 'form-control' . ($errors->has('tempo') ? ' is-invalid' : '' ),
        'min' => 0,
        'placeholder' => 'Tempo em Minutos'
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'tempo'])
    </div>

    <div class="col-md-12 col-lg-4 form-group">
      {!! Form::label('ativo', 'Status:') !!}
      {!! Form::select('ativo', [true => 'Ativo', false => 'Inativo'], $atividadeDesignada->ativo ?? old('ativo') ?? null, [
        'class' => 'form-control select2'
      ]) !!}
    </div>
  </div>

  <div class="row">
    <div class="col-12 form-group">
      {!! Form::label('descricao', 'Descrição:') !!}
      {!! Form::textarea('descricao', $atividadeDesignada->descricao ?? old('descricao') ?? null, [
        'class' => 'form-control' . ($errors->has('descricao') ? ' is-invalid' : '' ),
        'rows' => 3
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'descricao'])
    </div>
  </div>
</div>

<div class="card-footer">
  {!! Form::button("<em class='fa fa-arrow-left'></em> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('atividades.index') . "'"
  ]) !!}

  {!! Form::button("<em class='fas fa-save mr-1'></em> Salvar", [
    'class' => 'btn btn-success float-right',
    'type' => 'submit'
  ]) !!}
</div>

@push('scripts')
  <script>
    const turmas = $('#turmas');
    const equipes = $('#equipes');
    const alunos = $('#alunos');

    $(document).ready(function () {
      equipes.hide();
      alunos.hide();

      onChangeDesignarPara()
    });

    function onChangeDesignarPara() {
      const value = $('#designar_para').val();

      turmas.hide();
      equipes.hide();
      alunos.hide();

      if (value === 'equipe') {
        equipes.show();
      } else if (value === 'aluno') {
        alunos.show();
      } else {
        turmas.show();
      }
    }
  </script>
@endpush