@extends('web.plataforma._template.index')

@section('view')
    {{-- CABECARIO --}}
    @include('web.plataforma.acessos.pessoas.listar._includes.cabecario')

    {{-- TABELA --}}
    @include('web.plataforma.acessos.pessoas.listar._includes.tabela')

    {{-- SCRIPTS  --}}
    @component('web.plataforma._template._components.scripts', [
        'scripts' => [
            // JS PRINCIPAL
            'js/web/plataforma/acessos/pessoas/listar/index.js',
        ],
    ])
    @endcomponent
@endsection
