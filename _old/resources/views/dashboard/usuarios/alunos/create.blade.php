@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user', 'tituloPagina' => 'Alunos'])

@section('dashboard-content')
  <form action="{{ route('alunos.store') }}" method="POST">
    @csrf

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Novo Aluno</h5>
      </div>

      <div class="card-body">
        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'nome', 'label' => 'Nome'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'email', 'label' => 'E-mail', 'type' => 'email'])
          @input(['cols' => 'col-md-12 col-lg-2', 'name' => 'prontuario', 'label' => 'Prontuário'])
          @input(['cols' => 'col-md-12 col-lg-2', 'name' => 'data_nascimento', 'label' => 'Data de nascimento',
                  'type' => 'date', 'actions' => "onkeyup=calcularIdadeAluno($(this).val())"])
          @input(['cols' => 'col-md-12 col-lg-2', 'name' => 'cpf_responsavel', 'label' => 'CPF do responsável'])
        </div>

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-2', 'name' => 'usuario', 'label' => 'Usuário'])
          @input(['cols' => 'col-md-12 col-lg-2', 'name' => 'celular', 'label' => 'Celular'])
          @input(['cols' => 'col-md-12 col-lg-2', 'name' => 'telefone', 'label' => 'Telefone'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'password', 'label' => 'Senha', 'type' => 'password'])
          @input(['cols' => 'col-md-12 col-lg-3', 'name' => 'password_confirmation', 'label' => 'Confirmação da senha', 'type' => 'password'])
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['alunos.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script src="{{ asset('js/views/dashboard/usuarios/alunos/novo-aluno.js') }}"></script>
@endpush