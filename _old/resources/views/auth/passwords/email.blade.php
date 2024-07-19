@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/views/auth/auth.css') }}">
  <style>
    #div-recuperar-senha {
      background-color: #fff;
      width: 400px;
      padding: 50px 50px 30px;
    }

    @media (max-width: 575.98px) {
      #div-recuperar-senha {
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
    <div id="div-recuperar-senha">
      <form method="POST" action="{{ route('password.email') }}" class="login-form">
        @csrf

        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif

        @include('auth.partes.cabecalho', ['titulo' => 'RECUPERAR SENHA', 'classeIcon' => 'fa fa-key'])

        @input(['name' => 'email', 'label' => 'E-mail', 'value' => $email ?? old('email')])

        <div class="form-group btn-container">
          @button(['type' => 'primary', 'classes' => 'btn-block', 'icon' => 'fa fa-paper-plane', 'text' => 'ENVIAR'])
        </div>

        <div class="form-group mt-4">
          @include('auth.partes.botao-voltar')
          @include('auth.partes.rodape')
        </div>
      </form>
    </div>
  </section>
@endsection
