<div class="submenu" id="menu_acessos">
    <ul class="submenu-list" data-parent-element="#menu_acessos">
        {{-- PESSOAS --}}
        <li class="sub-submenu">
            <a role="menu" class="collapsed" data-toggle="collapse" data-target="#sub_pessoas" aria-expanded="false">
                Pessoas
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>
            <ul id="sub_pessoas" class="collapse" data-parent="#compact_submenuSidebar">
                <li>
                    <a href="{{ route('web.plataforma.acessos.pessoas.listar') }}">
                        Listar
                    </a>
                    <a href="#">
                        Cadastrar
                    </a>
                </li>
            </ul>
        </li>

        {{-- PERMISSÕES --}}
        <li class="sub-submenu">
            <a role="menu" class="collapsed" data-toggle="collapse" data-target="#sub_permissoes" aria-expanded="false">
                Permissões
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>
            <ul id="sub_permissoes" class="collapse" data-parent="#compact_submenuSidebar">
                <li>
                    <a href="#">
                        Gerais
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
