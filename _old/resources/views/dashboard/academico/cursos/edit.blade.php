@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-sitemap', 'tituloPagina' => 'Cursos'])

@section('dashboard-content')
  <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Curso</h5>
      </div>

      <div class="card-body row">
        <div class="col-md-12 col-lg-8">
          <fieldset>
            <legend>Dados do Curso</legend>

            @include('layouts.geral.alert')

            <div class="row">
              @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'nome', 'label' => 'Nome', 'value' => $curso->nome])
              @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'sigla', 'label' => 'Sigla', 'value' => $curso->sigla])
            </div>

            <div class="row">
              @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'nivel', 'label' => 'Nível', 'options' => [
                        ['value' => 'Infantil', 'content' => 'Infantil'],
                        ['value' => 'Fundamental', 'content' => 'Fundamental'],
                        ['value' => 'Médio', 'content' => 'Médio'],
                        ['value' => 'Técnico', 'content' => 'Técnico'],
                        ['value' => 'Graduação', 'content' => 'Graduação'],
                        ['value' => 'Pós-Graduação', 'content' => 'Pós-Graduação']
                      ], 'value' => $curso->nivel])

              @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'professores[]', 'label' => 'Professor', 'multiple' => true,
                       'classes' => 'js-example-basic-multiple', 'options' => $professores->map(function ($professor) {
                           return ['value' => $professor->id, 'content' => $professor->user->nome];
                       }), 'value' => $curso->professores_id])
            </div>

            @hasrole('administrador|diretor')
            <div class="row">
              @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'ativo', 'label' => 'Status', 'options' => [
                        ['value' => '1', 'content' => 'Ativo'],
                        ['value' => '0', 'content' => 'Inativo'],
                      ], 'value' => $curso->ativo])

              {{-- Carrega coordenadores via JavaScript, a partir da instituição do curso --}}
              @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'coordenador_id', 'label' => 'Coordenador', 'options' => []])
            </div>
            @endhasrole
          </fieldset>
        </div>

        <div class="col-md-12 col-lg-4">
          <fieldset>
            <legend>
              Disciplinas
              @button(['type' => 'info', 'classes' => 'float-right', 'icon' => 'fas fa-plus-circle',
                       'iconClasses' => 'mr-1', 'text' => 'Disciplina', 'route' => ['disciplinas.create']])
            </legend>

            <table class="table table-striped mt-3">
              <thead>
                <tr>
                  <th>Nome</th>
                </tr>
              </thead>

              <tbody>
                @forelse($curso->disciplinas as $disciplina)
                  <tr>
                    <td>
                      {{ $disciplina->nome }}
                      @button(['type' => 'secondary', 'classes' => 'float-right', 'icon' => 'fas fa-edit',
                               'route' => ['disciplinas.edit', $disciplina->id]])
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td>Nenhuma disciplina encontrada.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </fieldset>
        </div>
      </div>

      <div class="card-footer">
        @button(['type' => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['cursos.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script src="{{ asset('js/views/dashboard/academico/cursos/novo-curso.js') }}"></script>
  <script>
    const coordenadores = @json($coordenadores);

    $(document).ready(function () {
      $('#professores').select2();
      carregarCoordenadores('{{ $curso->instituicao->id }}', coordenadores, '{{ $curso->coordenador->id }}');
    });
  </script>
@endpush