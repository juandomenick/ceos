@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user', 'tituloPagina' => 'Termos de Aceite'])

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css">
@endpush

@section('dashboard-content')
  <form action="{{ route('termos-aceite.update', $termo->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Termo de Aceite</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          @input(['cols' => 'col-md-12 col-lg-8', 'name' => 'titulo', 'label' => 'Título', 'value' => $termo->titulo])
          @select(['cols' => 'col-md-12 col-lg-4', 'name' => 'ativo', 'label' => 'Status', 'options' => [
                    ['value' => '1', 'content' => 'Ativo'],
                    ['value' => '0', 'content' => 'Inativo'],
                  ], 'value' => $termo->ativo])
        </div>

        <div class="row">
          @textarea(['cols' => 'col-12', 'name' => 'descricao', 'label' => 'Descrição', 'value' => $termo->descricao])
        </div>
      </div>

      <div class="card-footer">
        @button(['type' => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['termos-aceite.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#descricao').summernote({ height: 300 });
      $('#ativo').select2({ minimumResultsForSearch: Infinity });
    });
  </script>
@endpush