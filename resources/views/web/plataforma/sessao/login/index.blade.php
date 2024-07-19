<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo9/auth_login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Aug 2020 20:40:52 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') . ' - Login' }}</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('web/plataforma/img/logo.svg') }}" />

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/plugins/font-awesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/css/elements/alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/css/structure.css') }}"class="structure">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/css/authentication/form-1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/plataforma/css/forms/switches.css') }}">
</head>

<body class="form">
    <div class="form-container">
        {{-- ACESSO --}}
        @include('web.plataforma.sessao.login._includes.acesso')

        {{-- BACKGROUND --}}
        @include('web.plataforma.sessao.login._includes.background')
    </div>

    <script src="{{ asset('web/plataforma/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('web/plataforma/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('web/plataforma/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/plataforma/js/authentication/form-1.js') }}"></script>
</body>

</html>
