@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user-tag', 'tituloPagina' => 'Coordenadores'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <a class="btn btn-success float-right" href="{{ route('coordenadores.create') }}">
        <i class="fas fa-plus-circle mr-1"></i> Coordenador
      </a>
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      <table class="table table-bordered table-responsive-lg" id="data-tables">
        <thead>
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Instituição</th>
          <th>Ações</th>
        </tr>
        </thead>

        <tbody>
        @foreach($coordenadores as $coordenador)
          <tr>
            <td>{{ $coordenador->user->nome }}</td>
            <td>{{ $coordenador->user->email }}</td>
            <td>{{ $coordenador->instituicao->sigla }}</td>

            <td>
              @button(["type" => 'primary', 'icon' => 'fas fa-edit', 'route' => ['coordenadores.edit', $coordenador->id]])

              <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('coordenadores.destroy', $coordenador->id) }}', 'Coordenador')">
                <i class="far fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection