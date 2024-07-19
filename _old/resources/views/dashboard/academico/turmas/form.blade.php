{!! Form::hidden('professor_id', $turma->professor_id ?? null) !!}

<div class="card-body">
  @include('layouts.geral.alert')

  <div class="row justify-content-between">
    <div class="form-group col-md-12 col-lg-6">
      {!! Form::label('nome', 'Nome:') !!}
      {!! Form::text('nome', $turma->nome ?? null, [
        'class' => 'form-control' . ($errors->has('nome') ? ' is-invalid' : '' )
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'nome'])
    </div>

    <div class="form-group flex-fill mr-3 ml-3">
      {!! Form::label('sigla', 'Sigla:') !!}
      {!! Form::text('sigla', $turma->sigla ?? null, [
        'class' => 'form-control' . ($errors->has('sigla') ? ' is-invalid' : '' )
      ]) !!}
      @include('layouts.forms.form-error', ['nomeCampo' => 'sigla'])
    </div>
  </div>

  <div class="row">
    @if(usuarioPodeAlterarTurma($turma ?? null))
      <div class="form-group col-md-12 col-lg-6">
        {!! Form::label('codigo_acesso', 'Código de Acesso:') !!}
        {!! Form::text('codigo_acesso', $turma->codigo_acesso ?? null, [
          'class' => 'form-control' . ($errors->has('codigo_acesso') ? ' is-invalid' : '' ),
          'disabled' => true
        ]) !!}
        @include('layouts.forms.form-error', ['nomeCampo' => 'codigo_acesso'])
      </div>

      @if (auth()->user()->hasRole('professor') || usuarioPodeAlterarTurma($turma ?? null))
        <div class="form-group col-md-12 col-lg-6">
          {!! Form::label('ativo', 'Status:') !!}
          {!! Form::select('ativo', $status, $turma->ativo ?? old('ativo'), [
            'class' => 'form-control select2'
          ])!!}
        </div>
      @endif
    @endif
  </div>

  <div class="row">
    @if (!isset($turma) || isset($turma->ano))
      <div class="form-group col-md-12 col-lg-6">
        {!! Form::label('ano', 'Ano:') !!}
        {!! Form::number('ano', $turma->ano ?? null, [
          'class' => 'form-control' . ($errors->has('ano') ? ' is-invalid' : '' )
        ]) !!}
        @include('layouts.forms.form-error', ['nomeCampo' => 'ano'])
      </div>

      <div class="form-group col-md-12 col-lg-6">
        {!! Form::label('semestre', 'Semestre:') !!}
        {!! Form::number('semestre', $turma->semestre ?? null, [
          'class' => 'form-control' . ($errors->has('semestre') ? ' is-invalid' : '' ),
          'min' => 1
        ]) !!}
        @include('layouts.forms.form-error', ['nomeCampo' => 'semestre'])
      </div>
    @endif
  </div>

  @if (!isset($turma) || isset($turma->curso))
    @if(!isset($turma) || (auth()->user()->hasRole('diretor|administrador') && usuarioPodeAlterarTurma($turma ?? null)))
      <div class="row">
        <div class="form-group col-md-12 col-lg-3">
          {!! Form::label('instituicao', 'Instituição:') !!}
          {!! Form::select('instituicao', $instituicoes, $turma->instituicao->id ?? old('instituicao') ?? null, [
            'class' => 'form-control select2'
          ]) !!}
        </div>

        <div class="form-group col-md-12 col-lg-3">
          {!! Form::label('curso', 'Curso:') !!}
          {!! Form::select('curso', [], null, ['class' => 'form-control select2']) !!}
        </div>

        <div class="form-group col-md-12 col-lg-3">
          {!! Form::label('disciplina_id', 'Disciplina:') !!}
          {!! Form::select('disciplina_id', [], null, [
            'class' => 'form-control select2' . ($errors->has('disciplina_id') ? ' is-invalid' : '' )
          ]) !!}
          @include('layouts.forms.form-error', ['nomeCampo' => 'disciplina_id'])
        </div>

        <div class="form-group col-md-12 col-lg-3">
          {!! Form::label('professor_id', 'Professor:') !!}
          {!! Form::select('professor_id', [], null, [
            'class' => 'form-control select2' . ($errors->has('professor_id') ? ' is-invalid' : '' )
          ]) !!}
          @include('layouts.forms.form-error', ['nomeCampo' => 'professor_id'])
        </div>
      </div>
    @endif
  @endif

  @if(usuarioPodeAlterarTurma($turma ?? null) && isset($turma))
    <div class="row">
      <div class="form-group col-12">
        {!! Form::label('alunos', 'Alunos:') !!}
        {!! Form::select('alunos[]', $turma->alunos, $turma->alunosId, [
          'class' => 'form-control select2 js-example-basic-multiple',
          'multiple' => true,
        ]) !!}
      </div>
    </div>
  @endif
</div>

<div class="card-footer">
  {!! Form::button("<em class='fa fa-arrow-left'></em> Voltar", [
    'class' => 'btn btn-primary float-left',
    'onclick' => "location.href='" . route('turmas.index') . "'"
  ]) !!}

  @if (usuarioPodeAlterarTurma($turma ?? null))
    {!! Form::button("<em class='fas fa-save mr-1'></em> Salvar", [
      'class' => 'btn btn-success float-right',
      'type' => 'submit'
    ]) !!}
  @endif
</div>

@push('scripts')
  <script src="{{ asset('js/views/dashboard/academico/turmas/nova-turma.js') }}"></script>
  <script>
    $(document).ready(function () {
      onChangeInstituicao(
        '{{ $turma->curso->id ?? old('curso') }}',
        '{{ $turma->disciplina->id ?? old('disciplina_id') }}',
        '{{ $turma->professor->id ?? old('professor_id') }}'
      );
    });
  </script>
@endpush

