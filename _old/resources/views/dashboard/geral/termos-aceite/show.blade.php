@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-scroll', 'tituloPagina' => 'Termos de Aceite'])

@section('dashboard-content')
  <div class="card">
    <div class="card-header">
      <h5 class="m-0">Termo de Aceite: {{ $termo->titulo }}</h5>
    </div>

    <div class="card-body">
      <div>
        {!! $termo->descricao !!}
      </div>
    </div>

    <div class="card-footer">
      @button(['type' => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['termos-aceite.index']])
      @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-edit', 'iconClasses' => 'mr-1',
              'text' => 'Editar', 'route' => ['termos-aceite.edit', $termo->id]])
    </div>
  </div>
@endsection