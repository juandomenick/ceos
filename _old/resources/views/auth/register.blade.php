@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/views/auth/auth.css') }}">
  <link rel="stylesheet" href="{{ asset('css/views/auth/register.css') }}">
@endpush

@section('content')
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>

  <section class="login-content">
    <div id="div-cadastro">
      <form method="POST" action="{{ route('register') }}" class="login-form">
        @csrf

        @include('auth.partes.cabecalho', ['titulo' => 'CADASTRO DE USUÁRIO', 'classeIcon' => 'fa fa-user-plus'])

        @input(['name' => 'avatar', 'type' => 'hidden', 'value' => old('avatar') ?? session('usuario')['avatar'] ?? null])
        @input(['name' => 'google_id', 'type' => 'hidden', 'value' => old('google_id') ?? session('usuario')['id'] ?? null])

        @select(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8', 'name' => 'perfil',
                 'label' => 'Perfil', 'actions' => 'onchange=perfilOnChange($(this).val())', 'options' => [
                  ['value' => 'aluno', 'content' => 'Aluno', 'selected' => true],
                  ['value' => 'professor', 'content' => 'Professor'],
                ]])

        @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8', 'name' => 'nome',
                'validationCols' => 'offset-lg-4', 'label' => 'Nome', 'value' => old('nome') ?? session('usuario')['name'] ?? null])

        <div id="dados-aluno">
          @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                  'validationCols' => 'offset-lg-4', 'actions' => 'onkeyup=calcularIdadeAluno($(this).val())',
                  'name' => 'data_nascimento', 'label' => 'Data de Nascimento', 'type' => 'date'])

          @input(['groupClasses' => 'row cpf-responsavel', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                  'validationCols' => 'offset-lg-4', 'name' => 'cpf_responsavel', 'label' => 'CPF do responsável'])

          @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                  'validationCols' => 'offset-lg-4', 'name' => 'prontuario', 'label' => 'Prontuário'])
        </div>

        <div id="dados-professor">
          @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                  'validationCols' => 'offset-lg-4', 'name' => 'matricula', 'label' => 'Matrícula'])
        </div>

        @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                'validationCols' => 'offset-lg-4', 'name' => 'celular', 'label' => 'Celular'])

        @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                'validationCols' => 'offset-lg-4', 'name' => 'telefone', 'label' => 'Telefone'])

        @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                'validationCols' => 'offset-lg-4', 'name' => 'email', 'label' => 'E-mail',
                'value' => old('email') ?? session('usuario')['email'] ?? null])

        @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                'validationCols' => 'offset-lg-4', 'name' => 'usuario', 'label' => 'Usuário'])

        @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8',
                'validationCols' => 'offset-lg-4', 'name' => 'password', 'label' => 'Senha', 'type' => 'password'])

        @input(['groupClasses' => 'row', 'labelClasses' => 'col-lg-4', 'controlClasses' => 'col-lg-8', 'type' => 'password',
                'validationCols' => 'offset-lg-4', 'name' => 'password_confirmation', 'label' => 'Confirmação da senha'])

        <div class="form-group row btn-container mt-4 d-flex justify-content-between">
          @button(['type' => 'primary', 'icon' => 'fas fa-arrow-left', 'text' => 'VOLTAR', 'route' => ['login']])
          @button(['type' => 'success', 'icon' => 'fas fa-save', 'text' => 'CADASTRAR'])
        </div>

        @include('auth.partes.rodape')
      </form>
    </div>
  </section>

  @push('scripts')
    <script src="{{ asset('js/views/auth/register.js') }}"></script>
  @endpush
@endsection
