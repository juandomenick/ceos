<div class='btn-group'>
  <a href="{{ route('habilidades.edit', $id) }}" class='btn btn-info'>
    <em class="fa fa-edit m-0 p-0"></em>
  </a>

  {!! Form::button('<em class="fa fa-trash m-0 p-0"></em>', [
    'type' => 'submit',
    'class' => 'btn btn-danger',
    'onclick' => "deletarRecurso('" . csrf_token() . "', '" . route('habilidades.destroy', $id) . "', 'Habilidade')"
  ]) !!}
</div>