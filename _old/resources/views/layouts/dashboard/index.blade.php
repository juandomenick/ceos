@extends('dashboard.dashboard', ['classesIcone' => $classesIcone, 'tituloPagina' => $tituloPagina])

@section('dashboard-content')
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      @isset ($rotaVoltar)
        <a class="btn btn-info float-left" href="{{ is_array($rotaVoltar) ? route($rotaVoltar[0], $rotaVoltar[1]) : route($rotaVoltar) }}">
          <em class="fas fa-arrow-left"></em>
        </a>
        <div class="ml-3"></div>
      @endisset

      @isset ($botaoAdd)
        <a class="btn btn-success float-right" href="{{ is_array($rotaAdd) ? route($rotaAdd[0], $rotaAdd[1]) : route($rotaAdd) }}">
          <em class="fas fa-plus-circle mr-1"></em> {{ $botaoAdd }}
        </a>
      @else
        <h5 class="m-0">{{ $tituloPagina }}</h5>
      @endisset
    </div>

    <div class="card-body">
      @include('layouts.geral.alert')

      {{ $dataTable->table() }}
    </div>
  </div>
@endsection

@push('scripts')
  {{ $dataTable->scripts() }}
@endpush