@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-code-branch', 'tituloPagina' => 'Disciplinas'])

@section('dashboard-content')
  <form action="{{ route('disciplinas.update', $disciplina->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Disciplina</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'nome', 'label' => 'Nome', 'value' => $disciplina->nome])
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'sigla', 'label' => 'Sigla', 'value' => $disciplina->sigla])
        </div>

        @hasrole('administrador|diretor|coordenador')
          @if(auth()->user()->hasRole('adminsitrator|diretor') ||
                (auth()->user()->hasRole('coordenador') &&
                 auth()->user()->coordenador->id == $disciplina->curso->coordenador_id))
            <div class="row">
              @select(['cols' => 'col-md-12 col-lg-4', 'name' => 'instituicao', 'label' => 'Instituição',
                       'options' => optionsInstitituicao($instituicoes), 'value' => $disciplina->curso->instituicao->id,
                       'actions' => 'onchange=onChangeCarregarCursos($(this).val())'])

              @select(['cols' => 'col-md-12 col-lg-4', 'name' => 'curso_id', 'label' => 'Curso', 'options' => []])

              @select(['cols' => 'col-md-12 col-lg-4', 'name' => 'ativo', 'label' => 'Status', 'options' => [
                      ['value' => '1', 'content' => 'Ativo'],
                      ['value' => '0', 'content' => 'Inativo'],
                    ], 'value' => $disciplina->ativo])
            </div>
          @endif
        @endhasrole
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['disciplinas.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script src="{{ asset('js/views/dashboard/academico/disciplinas/nova-disciplina.js') }}"></script>
  <script>
    const cursos = @json($cursos);

    $(document).ready(function () {
      carregarCursos('{{ $disciplina->curso->instituicao->id }}', cursos, '{{ $disciplina->curso->id }}')
    });

    function onChangeCarregarCursos(id) {
      carregarCursos(id, cursos, '{{ $disciplina->curso->id }}')
    }
  </script>
@endpush

