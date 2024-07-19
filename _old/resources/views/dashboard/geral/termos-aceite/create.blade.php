@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-scroll', 'tituloPagina' => 'Termos de Aceite'])

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css">
@endpush

@section('dashboard-content')
  <form action="{{ route('termos-aceite.store') }}" method="POST">
    @csrf

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Novo Termo de Aceite</h5>
      </div>

      <div class="card-body">
        <div class="row">
          @input(['cols' => 'col-12', 'name' => 'titulo', 'label' => 'Título'])
        </div>

        <div class="row">
          @textarea(['cols' => 'col-12', 'name' => 'descricao', 'label' => 'Descrição'])
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
    });
  </script>
@endpush