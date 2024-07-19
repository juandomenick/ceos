@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-university', 'tituloPagina' => 'Instituições'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      @hasrole('administrador')
        <a class="btn btn-success float-right" href="{{ route('instituicoes.create') }}">
          <i class="fas fa-plus-circle mr-1"></i> Instituição
        </a>
      @else
        <h5>Suas Instituições</h5>
      @endhasrole
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      <table class="table table-bordered table-responsive-lg" id="data-tables">
        <thead>
        <tr>
          <th>Nome</th>
          <th>Sigla</th>
          <th>Cidade</th>

          @hasrole('administrador')
            <th>Diretor</th>
          @endhasrole

          <th>Status</th>
          <th>Ações</th>
        </tr>
        </thead>

        <tbody>
          @foreach($instituicoes as $instituicao)
            <tr>
              <td>{{ $instituicao->nome }}</td>
              <td>{{ $instituicao->sigla }}</td>
              <td>{{ $instituicao->cidade->nome }} - {{ $instituicao->cidade->estado->uf }}</td>

              @hasrole('administrador')
                <td>
                  <a href="{{ route('diretores.edit', $instituicao->diretor->id) }}">{{ $instituicao->diretor->nome }}</a>
                </td>
              @endhasrole

              <td>
                <span class="badge {{ $instituicao->ativo ? 'badge-success' : 'badge-danger' }}">
                  {{ $instituicao->ativo ? 'Ativo' : 'Inativo' }}
                </span>
              </td>

              <td>
                @button(['type' => 'primary', 'icon' => 'fas fa-edit', 'route' => ['instituicoes.edit', $instituicao->id],
                         'text' => auth()->user()->hasRole('administrador') ? '' : ' Editar'])

                @hasrole('administrador')
                  <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('instituicoes.destroy', $instituicao->id) }}', 'Instituição')">
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