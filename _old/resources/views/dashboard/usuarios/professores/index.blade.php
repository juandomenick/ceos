@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-graduation-cap', 'tituloPagina' => 'Professores'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <a class="btn btn-success float-right" href="{{ route('professores.create') }}">
        <i class="fas fa-plus-circle mr-1"></i> Professor
      </a>
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      <table class="table table-bordered table-responsive-lg" id="data-tables">
        <thead>
          <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Prontuário</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($professores as $professor)
            <tr>
              <td>{{ $professor->user->nome }}</td>
              <td>{{ $professor->user->email }}</td>
              <td>{{ $professor->matricula }}</td>
              <td>
                @button(["type" => 'primary', 'icon' => 'fas fa-edit', 'route' => ['professores.edit', $professor->id]])

                <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('professores.destroy', $professor->id) }}', 'Professor')">
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