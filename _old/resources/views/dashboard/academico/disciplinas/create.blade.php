@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-code-branch', 'tituloPagina' => 'Disciplinas'])

@section('dashboard-content')
  <form action="{{ route('disciplinas.store') }}" method="POST">
    @csrf

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Nova Disciplina</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'nome', 'label' => 'Nome'])
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'sigla', 'label' => 'Sigla'])
        </div>

        <div class="row">
          @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'instituicao', 'label' => 'Instituição',
                   'options' => optionsInstitituicao($instituicoes), 'actions' => 'onchange=onChangeCarregarCursos($(this).val())'])

          @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'curso_id', 'label' => 'Curso', 'options' => []])
        </div>
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
    const oldCursoId = '{{ old('curso_id') }}';

    $(document).ready(function () {
      carregarCursos('{{ old('instituicao') }}', cursos, oldCursoId)
    });

    function onChangeCarregarCursos(id) {
      carregarCursos(id, cursos, oldCursoId)
    }
  </script>
@endpush