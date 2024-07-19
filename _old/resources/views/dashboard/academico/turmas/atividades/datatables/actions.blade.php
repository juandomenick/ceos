<div class='btn-group'>
  <a href="{{ route('turmas.atividades.edit', [$turma->id, $id]) }}" class='btn btn-info'>
    @if(turmaPertenceAoProfessor($turma))
      <em class="fa fa-edit m-0 p-0"></em>
    @else
      <em class="fa fa-eye m-0 p-0"></em>
    @endif
  </a>

  @if(turmaPertenceAoProfessor($turma))
    {!! Form::button('<em class="fa fa-trash m-0 p-0"></em>', [
      'type' => 'submit',
      'class' => 'btn btn-danger',
      'onclick' => "deletarRecurso('" . csrf_token() . "', '" . route('turmas.atividades.destroy', [$turma->id, $id]) . "', 'Atividade')"
    ]) !!}
  @endif
</div>