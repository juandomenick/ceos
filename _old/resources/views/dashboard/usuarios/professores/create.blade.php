@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-graduation-cap', 'tituloPagina' => 'Professores'])

@section('dashboard-content')
  <form action="{{ route('professores.store') }}" method="POST">
    @csrf

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Novo Professor</h5>
      </div>

      <div class="card-body">
        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'nome', 'label' => 'Nome'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'email', 'label' => 'E-mail', 'type' => 'email'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'matricula', 'label' => 'Matrícula'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'usuario', 'label' => 'Usuário'])
        </div>

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'celular', 'label' => 'Celular'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'telefone', 'label' => 'Telefone'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'password', 'label' => 'Senha', 'type' => 'password'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'password_confirmation', 'label' => 'Confirmação da senha', 'type' => 'password'])
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['professores.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection