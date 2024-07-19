@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-scroll', 'tituloPagina' => 'Termos de Aceite'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <a class="btn btn-success float-right" href="{{ route('termos-aceite.create') }}">
        <i class="fas fa-plus-circle mr-1"></i> Termo de Aceite
      </a>
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      <table class="table table-bordered table-responsive-lg" id="data-tables">
        <thead>
          <tr>
            <th class="w-75">Título</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
          @foreach($termos as $termo)
            <tr>
              <td class="w-75">{{ $termo->titulo }}</td>

              <td>
                <span class="badge {{ $termo->ativo ? "badge-success" : "badge-danger" }}">
                  {{ $termo->ativo ? "Ativo" : "Inativo" }}
                </span>
              </td>

              <td>
                @button(["type" => 'primary', 'icon' => 'fas fa-eye', 'route' => ['termos-aceite.show', $termo->id]])
                @button(["type" => 'success', 'icon' => 'fas fa-edit', 'route' => ['termos-aceite.edit', $termo->id]])

                <button class="btn btn-danger" onclick="deletarRecurso('{{ csrf_token() }}', '{{ route('termos-aceite.destroy', $termo->id) }}', 'Termo')">
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