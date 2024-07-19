@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user', 'tituloPagina' => 'Alunos'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <a class="btn btn-success float-right" href="{{ route('alunos.create') }}">
        <i class="fas fa-plus-circle mr-1"></i> Aluno
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
          @foreach($alunos as $aluno)
            <tr>
              <td>{{ $aluno->user->nome }}</td>
              <td>{{ $aluno->user->email }}</td>
              <td>{{ $aluno->prontuario }}</td>
              <td>
                @button(["type" => 'primary', 'icon' => 'fas fa-edit', 'route' => ['alunos.edit', $aluno->id]])

                <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('alunos.destroy', $aluno->id) }}', 'Aluno')">
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