<li class="nav-item dropdown user-profile-dropdown">
    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa-light fa-user"></i>
    </a>
    <div class="dropdown-menu position-absolute shadow animated fadeInUp" aria-labelledby="userProfileDropdown">
        <div class="user-profile-section">
            <div class="media mx-auto">
                <img src="{{ asset('web/plataforma/img/usuarios/' . (session()->get('login.Avatar') ?? '_avatar.png')) }}" class="img-fluid mr-2" alt="avatar">
                <div class="media-body">
                    <h5>{{ session()->get('login.NomePessoa') }}</h5>
                </div>
            </div>
        </div>
        <div class="dropdown-item">
            <a href="#">
                <i class="fa-light fa-user fa-lg mr-2"></i>
                <span>Meu Perfil</span>
            </a>
        </div>
        <div class="dropdown-item">
            <a href="#">
                <i class="fa-light fa-inbox fa-lg mr-2"></i>
                <span>Caixa de Entrada</span>
            </a>
        </div>
        <div class="dropdown-item">
            <a href="{{ route('web.plataforma.logout') }}">
                <i class="fa-light fa-door-open fa-lg mr-2 text-danger"></i>
                <span>Sair</span>
            </a>
        </div>
    </div>
</li>
