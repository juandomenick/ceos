@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user-tag', 'tituloPagina' => 'Coordenadores'])

@section('dashboard-content')
  <form action="{{ route('coordenadores.update', $coordenador->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Coordenador</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        @input(['name' => 'nome', 'label' => 'Nome', 'value' => $coordenador->user->nome])

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'value' => $coordenador->user->email, 'readonly' => true])
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'usuario', 'label' => 'Usuário', 'value' => $coordenador->user->usuario])
        </div>

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'celular', 'label' => 'Celular', 'value' => $coordenador->user->celular])
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'telefone', 'label' => 'Telefone', 'value' => $coordenador->user->telefone])
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['coordenadores.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection