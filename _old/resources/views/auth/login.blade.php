@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/views/auth/auth.css') }}">
  <link rel="stylesheet" href="{{ asset('css/views/auth/login.css') }}">
@endpush

@section('content')
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>

  <section class="login-content">
    <div id="div-login">
      <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        @include('auth.partes.cabecalho', ['titulo' => 'LOGIN', 'classeIcon' => 'fa fa-user'])

        @input(['cols' => 'usuario', 'name' => 'usuario', 'label' => 'Usuário'])
        @input(['cols' => 'password', 'name' => 'password', 'label' => 'Senha', 'type' => 'password'])

        <div class="form-group">
          <div class="utility d-flex justify-content-between">
            @checkbox(['name' => 'remember', 'label' => 'Lembrar-me'])

            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
            @endif
          </div>
        </div>

        <div class="form-group btn-container">
          @button(['type' => 'primary', 'classes' => 'btn-block', 'icon' => 'fas fa-sign-in-alt',
                   'iconClasses' => 'fa-lg fa-fw', 'text' => 'ENTRAR'])
        </div>

        @include('layouts.geral.botao-login-goole')

        <div class="form-group mt-4">
          <div class="utility d-flex justify-content-between">
            <p class="m-0">
              <a href="{{ route('register') }}">
                <i class="fas fa-user-plus"></i> CADASTRAR
              </a>
            </p>

            <p class="m-0">
              <a href="{{ route('login.responsavel') }}">
                <i class="fas fa-cogs"></i> RESPONSÁVEL
              </a>
            </p>
          </div>

          @include('auth.partes.rodape')
        </div>
      </form>
    </div>

    <i class="fa fa-3x fa-fw fa-question-circle" id="btn-modal-sobre" data-toggle="modal"
       data-target="#modal-sobre"></i>
  </section>

  <div class="modal fade" id="modal-sobre" tabindex="-1" role="dialog" aria-labelledby="modal-sobre" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center">Sobre o Céos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <h3>O Projeto</h3>
          <p class="text-justify">
            Projeto para uso acadêmico, gerenciamento de alunos, turmas, professores, atividades e gamificação.
            Ao professor cabe alimentar a base de dados e realizar simulados, provas teóricas e práticas
            impressas ou digitais, avaliação de habilidades e competências além do uso de gamificação dentro do
            processo de ensino/aprendizagem
          </p>

          <h4>Significado do nome "Céos"</h4>
          <p class="text-justify">
            De acordo com a mitologia grega, Ceos é o deus titã do norte e o titã da resolução, do conhecimento
            e da inteligência. A etimologia do nome de Ceos forneceu aos estudiosos a teorização de que ele
            também era o deus do intelecto e representava a mente inquisitiva, a resolução e a previsão.
          </p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
@endsection
