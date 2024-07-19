<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">
        {{-- LOGO --}}
        @include('web.plataforma._template._includes._header.logo')

        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <i class="fa-light fa-bars fa-2x"></i>
        </a>

        <ul class="navbar-item flex-row search-ul">
            {{-- <li class="nav-item align-self-center search-animated">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Pesquisar">
                    </div>
                </form>
            </li> --}}
        </ul>

        <ul class="navbar-item flex-row navbar-dropdown">
            {{-- MENSAGEM --}}
            @include('web.plataforma._template._includes._header.gemas')

            {{-- MENSAGEM --}}
            @include('web.plataforma._template._includes._header.mensagens')

            {{-- NOTIFICACOES --}}
            @include('web.plataforma._template._includes._header.notificacoes')

            {{-- PERFIL --}}
            @include('web.plataforma._template._includes._header.perfil')
        </ul>
    </header>
</div>
