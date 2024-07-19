@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-sitemap', 'tituloPagina' => 'Cursos'])

@section('dashboard-content')
  <form action="{{ route('cursos.store') }}" method="POST">
    @csrf

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Novo Curso</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          <div class="col-md-12 col-lg-6">
            <fieldset>
              <legend>Dados do Curso</legend>

              <div class="row">
                @input(['cols' => 'col-12', 'name' => 'nome', 'label' => 'Nome'])
              </div>

              <div class="row">
                @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'sigla', 'label' => 'Sigla'])

                @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'nivel', 'label' => 'Nível', 'options' => [
                         ['value' => 'Infantil', 'content' => 'Infantil'],
                         ['value' => 'Fundamental', 'content' => 'Fundamental'],
                         ['value' => 'Médio', 'content' => 'Médio'],
                         ['value' => 'Técnico', 'content' => 'Técnico'],
                         ['value' => 'Graduação', 'content' => 'Graduação'],
                         ['value' => 'Pós-Graduação', 'content' => 'Pós-Graduação']
                       ]])
              </div>

              <div class="row">
                @select(['cols' => 'col-12', 'name' => 'professores[]', 'label' => 'Professor', 'multiple' => true,
                         'classes' => 'js-example-basic-multiple', 'options' => $professores->map(function ($professor) {
                             return ['value' => $professor->id, 'content' => $professor->user->nome];
                         })])
              </div>
            </fieldset>
          </div>

          <div class="col-md-12 col-lg-6">
            <fieldset>
              <legend id="titulo">Dados do Coordenador</legend>

              <div class="row">
                <div class="col-12">
                  <div class="row">
                    @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'tipo-cadastro', 'label' => 'Tipo de Cadastro', 'options' => [
                              ['value' => 'novo-coordenador', 'content' => 'Novo Coordenador', 'selected' => true],
                              ['value' => 'selecionar-coordenador', 'content' => 'Selecionar Coordenador']
                            ], 'actions' => 'onchange=tipoCadastro($(this).val())'])

                    @select(['cols' => 'col-md-12 col-lg-6', 'name' => 'instituicao', 'label' => 'Instituição',
                    'options' => $instituicoes->map(function ($instituicao) {
                        return ['value' => $instituicao->id, 'content' => $instituicao->sigla];
                    }), 'actions' => 'onchange=onChageCarregarCoordenadores($(this).val())'])
                  </div>
                </div>

                <div class="col-12" id="novo-coordenador">
                  <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'coordenador[nome]', 'label' => 'Nome'])
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'coordenador[email]', 'label' => 'E-mail', 'type' => 'email'])
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'coordenador[usuario]', 'label' => 'Usuário'])
                  </div>

                  <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'coordenador[celular]', 'label' => 'Celular'])
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'coordenador[telefone]', 'label' => 'Telefone'])
                  </div>

                  <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'coordenador[password]', 'label' => 'Senha', 'type' => 'password'])
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'coordenador[password_confirmation]', 'label' => 'Confirmação da senha', 'type' => 'password'])
                  </div>
                </div>

                <div class="col-12" id="selecionar-coordenador">
                  <div class="row">
                    {{-- Carrega coordenadores via JavaScript, a partir da instituição selecionada --}}
                    @select(['cols' => 'col-lg-12', 'name' => 'coordenador_id', 'label' => 'Coordenador', 'options' => []])
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['cursos.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>

@endsection

@push('scripts')
  <script src="{{ asset('js/views/dashboard/academico/cursos/novo-curso.js') }}"></script>
  <script>
    const coordenadores = @json($coordenadores);
    const oldCoordenadorId = '{{ old('coordenador_id') }}';

    $(document).ready(function () {
      $('#professores').select2();
      tipoCadastro('{{ old('tipo-cadastro') }}');
      carregarCoordenadores('{{ old('instituicao') }}', coordenadores, oldCoordenadorId);
    });

    function onChageCarregarCoordenadores(id) {
      carregarCoordenadores(id, coordenadores, oldCoordenadorId);
    }
  </script>
@endpush