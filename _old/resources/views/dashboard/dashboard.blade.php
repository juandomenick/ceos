@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.20/datatables.min.css"/>
@endpush

@section('content')
  @include('layouts.dashboard.nav')

  @include('layouts.dashboard.sidebar')

  <div class="app-content">
    <div class="app-title">
      <div>
        <h1>
          <i class="{{ $classesIcone ?? 'fas fa-tachometer-alt' }} mr-2"></i> {{ $tituloPagina ?? 'Dashboard' }}
        </h1>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        @yield('dashboard-content')
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
  <script src="{{ asset('js/views/dashboard/dashboard.js') }}"></script>
@endpush