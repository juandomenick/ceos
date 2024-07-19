@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user-tie', 'tituloPagina' => 'Diretores'])

@section('dashboard-content')
  <form action="{{ route('diretores.store') }}" method="POST">
    @csrf

    <div class="card">
      <div class="card-header">
        <h5 class="m-0" id="titulo">Novo Diretor</h5>
      </div>

      <div class="card-body row">
       <div class="col-12">
         @select(['name' => 'tipo-cadastro', 'label' => 'Tipo de Cadastro', 'options' => [
            ['value' => 'novo-diretor', 'content' => 'Novo Diretor', 'selected' => true],
            ['value' => 'promover-professor', 'content' => 'Promover Professor']
         ], 'actions' => 'onchange=tipoCadastro($(this).val())'])
       </div>

        <div class="col-12" id="novo-diretor">
          <div class="row">
            @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'nome', 'label' => 'Nome'])
            @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'email', 'label' => 'E-mail', 'type' => 'email'])
            @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'usuario', 'label' => 'Usuário'])
          </div>

          <div class="row">
            @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'celular', 'label' => 'Celular'])
            @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'telefone', 'label' => 'Telefone'])
            @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'password', 'label' => 'Senha', 'type' => 'password'])
            @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'password_confirmation', 'label' => 'Confirmação da senha', 'type' => 'password'])
          </div>
        </div>

        <div class="col-12" id="promover-professor">
          @select(['name' => 'professor', 'label' => 'Professor', 'options' => $professores->map(function ($professor) {
            if (!$professor->user->hasRole('diretor'))
              return ['value' => $professor->user->id, 'content' => $professor->user->nome];
          })])
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['diretores.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script src="{{ asset('js/views/dashboard/usuarios/diretores/novo-diretor.js') }}"></script>
  <script>
    $(document).ready(function () {
      tipoCadastro('{{ old('tipo-cadastro') }}');
    });
  </script>
@endpush