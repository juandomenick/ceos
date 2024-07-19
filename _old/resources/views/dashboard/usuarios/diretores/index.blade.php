@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user-tie', 'tituloPagina' => 'Diretores'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <a class="btn btn-success float-right" href="{{ route('diretores.create') }}">
        <i class="fas fa-plus-circle mr-1"></i> Diretor
      </a>
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      <table class="table table-bordered table-responsive-lg" id="data-tables">
        <thead>
          <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Instituições</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($diretores as $diretor)
            @if (auth()->user()->id != $diretor->id)
              <tr>
                <td>{{ $diretor->nome }}</td>
                <td>{{ $diretor->email }}</td>

                <td>
                  @forelse($diretor->instituicoes as $instituicao)
                    @if ($loop->last)
                      {{ $instituicao['sigla'] }}
                    @else
                      {{ $instituicao['sigla'] }},
                    @endif
                  @empty
                    <span>-</span>
                  @endforelse
                </td>

                <td>
                  @button(["type" => 'primary', 'icon' => 'fas fa-edit', 'route' => ['diretores.edit', $diretor->id]])

                  <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('diretores.destroy', $diretor->id) }}', 'Diretor')">
                    <i class="far fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection