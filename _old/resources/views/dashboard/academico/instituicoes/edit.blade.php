@extends('dashboard.dashboard', ['classesIcone' => 'fas fa-university', 'tituloPagina' => 'Instituições'])

@section('dashboard-content')
  <form action="{{ route('instituicoes.update', $instituicao->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Instituição</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'nome', 'label' => 'Nome', 'value' => $instituicao->nome])
          @input(['cols' => 'col-md-12 ' . (auth()->user()->hasRole('administrador') ? 'col-lg-3' : 'col-lg-6'),
                  'name' => 'telefone', 'label' => 'Telefone', 'value' => $instituicao->telefone])

          @hasrole('administrador')
            @select(['cols' => 'col-md-12 col-lg-3', 'name' => 'ativo', 'label' => 'Status', 'options' => [
                      ['value' => '1', 'content' => 'Ativo'],
                      ['value' => '0', 'content' => 'Inativo'],
                    ], 'value' => $instituicao->ativo])
          @endhasrole
        </div>

        <div class="row">
          @input(['cols' => 'col-md-12 ' . (auth()->user()->hasRole('administrador') ? 'col-lg-4' : 'col-lg-6'),
                  'name' => 'sigla', 'label' => 'Sigla', 'value' => $instituicao->sigla])

          @hasrole('administrador')
            @select(['cols' => 'col-md-12 col-lg-4', 'name' => 'diretor', 'label' => 'Diretor',
                     'options' => $diretores->map(function ($diretor) {
                         if (auth()->user()->getAuthIdentifier() !== $diretor->id)
                             return ['value' => $diretor->id, 'content' => $diretor->nome];
                     }), 'value' => $instituicao->diretor->id])
          @endhasrole

          @select(['cols' => 'col-md-12 ' . (auth()->user()->hasRole('administrador') ? 'col-lg-2' : 'col-lg-3'),
                   'name' => 'estados', 'label' => 'Estado', 'options' => [],
                   'actions' => 'onchange=carregarCidades($(this).val())'])
          @select(['cols' => 'col-md-12 ' . (auth()->user()->hasRole('administrador') ? 'col-lg-2' : 'col-lg-3'),
                   'name' => 'cidades', 'label' => 'Cidade', 'options' => []])
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
  <script>
    $(document).ready(function () {
      carregarEstados('{{ $instituicao->cidade->estado->id }}', '{{ $instituicao->cidade->id }}');

      $('#estados').select2();
      $('#cidades').select2();
      $('#diretor').select2();
      $('#ativo').select2({ minimumResultsForSearch: Infinity });
    });
  </script>
@endpush

