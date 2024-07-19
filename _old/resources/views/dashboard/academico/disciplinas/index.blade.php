@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-code-branch', 'tituloPagina' => 'Disciplinas'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      @hasrole('administrador|diretor|coordenador')
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-plus-circle',
                 'iconClasses' => 'mr-1', 'text' => 'Disciplina', 'route' => ['disciplinas.create']])
      @else
        <h5>Suas Disciplinas</h5>
      @endhasrole
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      <table class="table table-bordered table-responsive-lg" id="data-tables">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Curso</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($disciplinas as $disciplina)
            <tr>
              <td>{{ $disciplina->nome }}</td>
              <td>{{ $disciplina->sigla }}</td>

              <td>
                @hasrole('administrador|diretor|coordenador')
                  @if(auth()->user()->hasRole('adminsitrator|diretor') ||
                        (auth()->user()->hasRole('coordenador') &&
                         auth()->user()->coordenador->id == $disciplina->curso->coordenador_id))
                    <a href="{{ route('cursos.edit', $disciplina->curso->id) }}">
                      {{ $disciplina->curso->nome }}
                    </a>
                  @else
                    {{ $disciplina->curso->nome }}
                  @endif
                @else
                  {{ $disciplina->curso->nome }}
                @endhasrole
              </td>

              <td>
                <span class="badge {{ $disciplina->ativo ? 'badge-success' : 'badge-danger' }}">
                  {{ $disciplina->ativo ? 'Ativo' : 'Inativo' }}
                </span>
              </td>

              <td>
                @button(['type' => 'primary', 'icon' => 'fas fa-edit', 'route' => ['disciplinas.edit', $disciplina->id],
                         'text' => auth()->user()->hasRole('administrador|diretor|coordenador') ? '' : ' Editar'])

                @hasrole('administrador|diretor|coordenador')
                  <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('disciplinas.destroy', $disciplina->id) }}', 'Disciplina')">
                    <i class="far fa-trash-alt"></i>
                  </button>
                @endhasrole
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection