@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/views/auth/auth.css') }}">
  <style>
    #div-nova-senha {
      background-color: #fff;
      width: 400px;
      padding: 50px 50px 30px;
    }

    @media (max-width: 575.98px) {
      #div-nova-senha {
        width: auto;
        margin: 25px;
        padding: 30px 30px 10px;
      }
    }

  </style>
@endpush

@section('content')
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>

  <section class="login-content">
    <div id="div-nova-senha">
      <form method="POST" action="{{ route('password.update') }}" class="login-form">
        @csrf

        @include('auth.partes.cabecalho', ['titulo' => 'NOVA SENHA', 'classeIcon' => 'fa fa-key'])

        @input(['name' => 'token', 'type' => 'hidden', 'value' => $token])
        @input(['name' => 'email', 'label' => 'E-mail'])
        @input(['name' => 'password', 'label' => 'Senha', 'type' => 'password'])
        @input(['name' => 'password_confirmation', 'label' => 'Confirmação da senha', 'type' => 'password'])

        <div class="form-group btn-container">
          @button(['type' => 'primary', 'classes' => 'btn-block', 'icon' => 'fas fa-save', 'text' => 'REDEFINIR SENHA'])
        </div>

        <div class="form-group mt-4">
          @include('auth.partes.botao-voltar')
          @include('auth.partes.rodape')
        </div>
      </form>
    </div>
  </section>
@endsection
