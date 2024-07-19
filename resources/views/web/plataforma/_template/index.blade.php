<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('web/plataforma/img/logo.svg') }}" />

    {{-- CSS --}}
    @include('web.plataforma._template._includes._assets.css')

    {{-- LOADER  --}}
    <script src="{{ asset('web/plataforma/js/loader.js') }}"></script>
</head>

<body class="dashboard-analytics">
    {{-- LOADER  --}}
    @include('web.plataforma._template._includes.loader')

    {{-- HEADER --}}
    @include('web.plataforma._template._includes.header')

    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>

        {{-- SIDEBAR --}}
        @include('web.plataforma._template._includes.sidebar')

        {{-- CONTENT --}}
        @include('web.plataforma._template._includes.content')
    </div>

    {{-- SCRIPTS  --}}
    @include('web.plataforma._template._includes._assets.scripts')
</body>

</html>
