<div class='btn-group'>
  <a href="{{ route('atividades.edit', $id) }}" class='btn btn-info'>
    <em class="fa fa-edit m-0 p-0"></em>
  </a>

  @if(auth()->user()->hasRole('professor') && $professor_id === auth()->user()->professor->id)
    <a href="{{ route('atividades.designar.create', $id) }}" class='btn btn-primary'>
      <em class="fa fa-check m-0 p-0"></em>
    </a>
  @endif

  {!! Form::button('<em class="fa fa-trash m-0 p-0"></em>', [
    'type' => 'submit',
    'class' => 'btn btn-danger',
    'onclick' => "deletarRecurso('" . csrf_token() . "', '" . route('atividades.destroy', $id) . "', 'Atividade')"
    ]) !!}
</div>