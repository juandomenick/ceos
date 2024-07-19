<div class='btn-group'>
  <a href="{{ route('turmas.edit', $turma->id) }}" class='btn btn-info'>
    @if (usuarioPodeAlterarTurma($turma))
      <em class="fa fa-edit m-0 p-0"></em>
    @else
      <em class="fa fa-eye m-0 p-0"></em>
    @endif
  </a>

  @if (auth()->user()->hasRole('administrador|diretor') && usuarioPodeAlterarTurma($turma))
    {!! Form::button('<em class="fa fa-trash m-0 p-0"></em>', [
      'type' => 'submit',
      'class' => 'btn btn-danger',
      'onclick' => "deletarRecurso('" . csrf_token() . "', '" . route('turmas.destroy', $turma->id) . "', 'Turma')"
    ]) !!}
  @endif
</div>