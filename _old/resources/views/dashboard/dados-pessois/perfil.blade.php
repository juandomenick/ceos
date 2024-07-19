@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user-cog', 'tituloPagina' => 'Perfil'])

@push('styles')
    <style>
        #btn-login-google {
            color: #858585;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .25);
            font-family: 'Roboto', sans-serif;
            font-weight: normal;
            border-radius: 0;
        }
    </style>
@endpush

@section('dashboard-content')
    <form action="{{ route('perfil.atualizar',auth()->user()->getAuthIdentifier()) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header d-flex justify-content-between align-content-center flex-wrap pb-0">
                <h5 class="m-0">Atualizar Perfil</h5>

                <form action="">
                    @if (auth()->user()->google_id)
                        @include('layouts.geral.botao-login-goole', ['classeCss' => 'disabled', 'textoBotao' => 'Conta Vinculada'])
                    @else
                        @include('layouts.geral.botao-login-goole', ['textoBotao' => 'Vincular com Google'])
                    @endif
                </form>
            </div>

            <div class="card-body">
                @include('layouts.geral.alert')

                <div class="row">
                    @inputFile(['cols' => 'col-12', 'name' => 'avatar', 'label' => 'Avatar', 'value' => old('avatar') ?? auth()->user()->avatar])
                </div>

                <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'nome', 'label' => 'Nome', 'value' => old('nome') ?? auth()->user()->nome])
                    @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'email', 'label' => 'E-mail', 'readonly' => true, 'value' => old('email') ?? auth()->user()->email])
                </div>

                <div class="row">
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'usuario', 'label' => 'Usuário', 'value' => old('usuario') ?? auth()->user()->usuario])
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'celular', 'label' => 'Celular', 'value' => old('celular') ?? auth()->user()->celular])
                    @input(['cols' => 'col-md-12 col-lg-4', 'name' => 'telefone', 'label' => 'Telefone', 'value' => old('telefone') ?? auth()->user()->telefone])
                </div>
            </div>

            <div class="card-footer">
                @button([
                    'type' => 'primary',
                    'classes' => 'float-right',
                    'icon' => 'fa fa-floppy-o',
                    'text' => 'SALVAR',
                ])
            </div>
        </div>
    </form>
@endsection
