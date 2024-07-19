<div class='btn-group'>
  @hasrole('professor')
    <a href="{{ route('questoes.duplicar', $id) }}" class='btn btn-secondary'>
      <i class="fa fa-copy m-0 p-0"></i>
    </a>
  @endhasrole

  <a href="{{ route('questoes.edit', $id) }}" class='btn btn-info'>
    @if (auth()->user()->hasRole('professor') && auth()->user()->professor->id == $professor['id'])
      <i class="fa fa-edit m-0 p-0"></i>
    @else
      <i class="fa fa-eye m-0 p-0"></i>
    @endif
  </a>

  @if (auth()->user()->hasRole('professor') && auth()->user()->professor->id == $professor['id'])
    {!! Form::button('<i class="fa fa-trash m-0 p-0"></i>', [
      'type' => 'submit',
      'class' => 'btn btn-danger',
      'onclick' => "deletarRecurso('" . csrf_token() . "', '" . route('questoes.destroy', $id) . "', 'Questão')"
    ]) !!}
  @endif
</div>