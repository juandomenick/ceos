@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user-lock', 'tituloPagina' => 'Atualizar Senha'])

@section('dashboard-content')
  <form action="{{ route('senha.atualizar', auth()->user()->getAuthIdentifier()) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Atualizar Senha</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'senha_atual', 'label' => 'Senha atual',
                  'type' => 'password', 'notRemember' => true])
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'nova_senha', 'label' => 'Senha', 'type' => 'password',
                  'notRemember' => true])
          @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'nova_senha_confirmation', 'label' => 'Confirmação da senha',
                  'type' => 'password', 'notRemember' => true])
        </div>
      </div>

      <div class="card-footer">
        @button(['type' => 'primary', 'classes' => 'float-right', 'icon' => 'fa fa-floppy-o', 'text' => 'SALVAR'])
      </div>
    </div>
  </form>
@endsection