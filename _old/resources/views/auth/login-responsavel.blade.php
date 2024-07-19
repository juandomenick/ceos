@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/views/auth/auth.css') }}">
  <style>
    #div-login {
      background-color: #fff;
      width: 400px;
      padding: 50px 50px 30px;
    }

    @media (max-width: 575.98px) {
      #div-login {
        width: auto;
        padding: 30px 30px 25px;
        margin: 40px;
      }
    }
  </style>
@endpush

@section('content')
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>

  <section class="login-content">
    <div id="div-login">
      <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        @include('auth.partes.cabecalho', ['titulo' => 'LOGIN RESPONSÁVEL', 'classeIcon' => 'fas fa-user'])

        <div class="form-group mt-4">
          <div class="utility">
            <p class="text-center">
              No 1º acesso utilize o CPF como Login e Senha.
            </p>
          </div>
        </div>

        @input(['cols' => 'usuario', 'name' => 'usuario', 'label' => 'CPF', 'placeholder' => 'CPF do Responsável'])
        @input(['cols' => 'password', 'name' => 'password', 'label' => 'Senha', 'type' => 'password'])

        <div class="form-group">
          <div class="utility d-flex justify-content-between">
            @checkbox(['name' => 'remember', 'label' => 'Lembrar-me'])
          </div>
        </div>

        <div class="form-group btn-container">
          @button(['type' => 'primary', 'classes' => 'btn-block', 'icon' => 'fas fa-sign-in-alt',
                   'iconClasses' => 'fa-lg fa-fw', 'text' => 'ENTRAR'])
        </div>

        <div class="form-group mt-4">
          @include('auth.partes.botao-voltar')
        </div>

        @include('auth.partes.rodape')
      </form>
    </div>
  </section>

  @push('scripts')
    <script>
      $(document).ready(function () {
        $('#usuario').mask("999.999.999-99");
      });
    </script>
  @endpush
@endsection
