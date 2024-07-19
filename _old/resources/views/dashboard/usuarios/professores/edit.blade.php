@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-graduation-cap', 'tituloPagina' => 'Professores'])

@section('dashboard-content')
  <form action="{{ route('professores.update', $professor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Professor</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'nome', 'label' => 'Nome', 'value' => $professor->user->nome])
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'matricula', 'label' => 'Matrícula', 'value' => $professor->matricula])
        </div>

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'value' => $professor->user->email])
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'celular', 'label' => 'Celular', 'value' => $professor->user->celular])
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'telefone', 'label' => 'Telefone', 'value' => $professor->user->telefone])
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['professores.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection