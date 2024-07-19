<div class='btn-group'>
  <a href="{{ route('anotacoes-aula.edit', $id) }}" class='btn btn-info'>
    <i class="fa fa-edit m-0 p-0"></i>
  </a>

  {!! Form::button('<i class="fa fa-trash m-0 p-0"></i>', [
    'type' => 'submit',
    'class' => 'btn btn-danger',
    'onclick' => "deletarRecurso('" . csrf_token() . "', '" . route('anotacoes-aula.destroy', $id) . "', 'Anotação de Aula')"
  ]) !!}
</div>