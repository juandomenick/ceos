@push('styles')
  <style>
    .avatar-usuario {
      width: 50px;
      height: 50px;
    }
  </style>
@endpush

<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <img class="app-sidebar__user-avatar avatar-usuario" src="{{ $avatar }}" alt="Avatar do Usuário">
    <div>
      <p class="app-sidebar__user-name">{{ $nomeUsuario }}</p>
      <p class="app-sidebar__user-designation">{{ $funcao }}</p>
    </div>
  </div>

  @if (isset($sidebarItems['sidebar_items']))
    <ul class="app-menu">
      @foreach ($sidebarItems['sidebar_items'] as $sidebarItem)
        @if (isset($sidebarItem['role']) && auth()->user()->hasRole($sidebarItem['role']))
          <li class="treeview">
            <a class="app-menu__item" href="{{ isset($sidebarItem['route']) ? route($sidebarItem['route']) : '' }}"
               @if (isset($sidebarItem['subitems'])) data-toggle="treeview" @endif>
              <i class="app-menu__icon {{ $sidebarItem['icon'] }}"></i>
              <span class="app-menu__label">{{ $sidebarItem['title'] }}</span>
              @if (isset($sidebarItem['subitems']))
                <i class="treeview-indicator fa fa-angle-right"></i>
              @endif
            </a>

            @if (isset($sidebarItem['subitems']))
              <ul class="treeview-menu">
                @foreach ($sidebarItem['subitems'] as $sidebarSubitem)
                  @if ((isset($sidebarSubitem['role']) && auth()->user()->hasRole($sidebarSubitem['role'])) || !isset($sidebarSubitem['role']))
                    <li>
                      <a class="treeview-item" href="{{ route($sidebarSubitem['route']) }}">
                        <i class="icon {{ $sidebarSubitem['icon'] }}"></i> {{ $sidebarSubitem['title'] }}
                      </a>
                    </li>
                  @endif
                @endforeach
              </ul>
            @endif
          </li>
        @endif
      @endforeach

      <li class="treeview">
        <form action="{{ route('logout') }}" method="POST">
          @csrf

          <button class="btn btn-block app-menu__item">
            <i class="app-menu__icon fas fa-sign-out-alt"></i> Sair
          </button>
        </form>
      </li>

      @hasrole('aluno')
        <h3 class="text-white text-center mt-5 font-weight-normal">Simulado</h3>
        <img src="{{ asset('img/dashboard/qrcode-simulado.png') }}" alt="QR Code Simulado" class="img-fluid pt-2 pl-5 pr-5">
      @endhasrole
    </ul>
  @endif
</aside>