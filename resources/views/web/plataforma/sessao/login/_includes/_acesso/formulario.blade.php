<form action="{{ route('web.plataforma.login') }}" method="POST" enctype="multipart/form-data" class="text-left">
    @csrf
    <div class="form">
        <div id="username-field" class="field-wrapper input">
            <i class="fa-light fa-user {{ $errors->has('Acesso') ? 'text-danger' : '' }}"></i>
            <input class="form-control lowercase {{ $errors->has('Acesso') ? 'is-invalid border-bottom border-danger' : '' }}" type="text" id="Acesso" name="Acesso" placeholder="Acesso" value="{{ old('Acesso') }}">
        </div>
        <div id="password-field" class="field-wrapper input mb-2">
            <i class="fa-light fa-lock {{ $errors->has('Senha') ? 'text-danger' : '' }}"></i>
            <input class="form-control {{ $errors->has('Senha') ? 'is-invalid border-bottom border-danger' : '' }}" type="password" id="Senha" name="Senha" placeholder="Senha" value="{{ old('Senha') }}">
        </div>
        <div class="d-sm-flex justify-content-between">
            <div class="field-wrapper toggle-pass">
                <p class="d-inline-block">Mostrar senha</p>
                <label class="switch s-primary">
                    <input type="checkbox" id="toggle-password" class="d-none">
                    <span class="slider round"></span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-light fa-arrow-right-to-bracket mr-2"></i>
                Logar
            </button>
        </div>
    </div>
</form>
