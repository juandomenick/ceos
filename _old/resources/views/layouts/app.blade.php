<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Céos') }}</title>

  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  @stack('styles')
</head>
<body class="app sidebar-mini">
  <main>
    @yield('content')
  </main>

  <script src="https://kit.fontawesome.com/5ed1634b0f.js" crossorigin="anonymous"></script>
  <script src="{{ mix('js/app.js') }}"></script>
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

  @stack('scripts')
</body>
</html>
