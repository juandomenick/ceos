@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-sitemap', 'tituloPagina' => 'Cursos'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      @hasrole('administrador|diretor')
        <a class="btn btn-success float-right" href="{{ route('cursos.create') }}">
          <i class="fas fa-plus-circle mr-1"></i> Curso
        </a>
      @else
        <h5>Seus Cursos</h5>
      @endhasrole
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      <table class="table table-bordered table-responsive-lg" id="data-tables">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Nível</th>

            @hasrole('administrador')
              <th>Instituição</th>
            @endhasrole

            @hasrole('diretor')
              <th>Coordenador</th>
            @endhasrole

            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($cursos as $curso)
            <tr>
              <td>{{ $curso->nome }}</td>
              <td>{{ $curso->sigla }}</td>
              <td>{{ $curso->nivel }}</td>

              @hasrole('administrador')
                <td>
                  <a href="{{ route('instituicoes.edit', $curso->instituicao->id) }}">{{ $curso->instituicao->sigla }}</a>
                </td>
              @endhasrole

              @hasrole('diretor')
                <td>
                  <a href="{{ route('coordenadores.edit', $curso->coordenador->id) }}">{{ $curso->coordenador->user->nome }}</a>
                </td>
              @endhasrole

              <td>
                <span class="badge {{ $curso->ativo ? "badge-success" : "badge-danger" }}">
                  {{ $curso->ativo ? "Ativo" : "Inativo" }}
                </span>
              </td>

              <td>
                @button(["type" => 'primary', 'icon' => 'fas fa-edit', 'route' => ['cursos.edit', $curso->id]])

                @hasrole('administrador|diretor')
                  <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('cursos.destroy', $curso->id) }}', 'Curso')">
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