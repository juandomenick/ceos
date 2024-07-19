@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user', 'tituloPagina' => 'Alunos'])

@section('dashboard-content')
  <form action="{{ route('alunos.update', $aluno->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Aluno</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'nome', 'label' => 'Nome', 'value' => $aluno->user->nome])

          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'prontuario', 'label' => 'Prontuário', 'value' => $aluno->prontuario])
        </div>

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'value' => $aluno->user->email])
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'celular', 'label' => 'Celular', 'value' => $aluno->user->celular])
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'telefone', 'label' => 'Telefone', 'value' => $aluno->user->telefone])
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['alunos.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection