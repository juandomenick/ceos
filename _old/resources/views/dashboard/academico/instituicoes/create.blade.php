@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-university', 'tituloPagina' => 'Instituições'])

@section('dashboard-content')
  <form action="{{ route('instituicoes.store') }}" method="POST">
    @csrf

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Nova Instituição</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          <div class="col-md-12 col-lg-6">
            <fieldset>
              <legend>Dados da Instituição</legend>

              <div class="row">
                @input(['cols' => 'col-12', 'name' => 'nome', 'label' => 'Nome'])
              </div>

              <div class="row">
                @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'sigla', 'label' => 'Sigla'])
                @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'telefone', 'label' => 'Telefone'])
              </div>

              <div class="row">
                @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'estados', 'label' => 'Estado', 'options' => [],
                         'actions' => 'onchange=carregarCidades($(this).val())'])
                @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'cidades', 'label' => 'Cidade', 'options' => []])
              </div>
            </fieldset>
          </div>

          <div class="col-md-12 col-lg-6">
            <fieldset>
              <legend id="titulo">Dados do Diretor</legend>

              <div class="row">
                @select(['cols' => 'col-12', 'name' => 'tipo-cadastro', 'label' => 'Tipo de Cadastro', 'options' => [
                          ['value' => 'novo-diretor', 'content' => 'Novo Diretor', 'selected' => true],
                          ['value' => 'selecionar-diretor', 'content' => 'Selecionar Diretor']
                        ], 'actions' => 'onchange=tipoCadastro($(this).val())'])

                <div class="col-12" id="novo-diretor">
                  <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'diretor[nome]', 'label' => 'Nome'])
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'diretor[email]', 'label' => 'E-mail',
                            'type' => 'email'])
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'diretor[usuario]', 'label' => 'Usuário'])
                  </div>

                  <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'diretor[celular]', 'label' => 'Celular'])
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'diretor[telefone]', 'label' => 'Telefone'])
                  </div>

                  <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'diretor[password]', 'label' => 'Senha',
                            'type' => 'password'])
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'diretor[password_confirmation]',
                            'label' => 'Confirmação da senha', 'type' => 'password'])
                  </div>
                </div>

                <div class="col-12" id="selecionar-diretor">
                  @select(['name' => 'diretor_id', 'label' => 'Diretor', 'options' => $diretores->map(function ($diretor) {
                              return ['value' => $diretor->id, 'content' => $diretor->nome];
                          })])
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['instituicoes.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script src="{{ asset('js/views/dashboard/academico/cursos/nova-instituicao.js') }}"></script>
  <script>
    $(document).ready(function () {
      tipoCadastro('{{ old('tipo-cadastro') }}');
      carregarEstados('{{ old('estados') }}', '{{ old('cidades') }}');
    });
  </script>
@endpush