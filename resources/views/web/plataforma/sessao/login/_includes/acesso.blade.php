<div class="form-form">
    <div class="row justify-content-center m-0">
        <div class="col-lg-6 p-5">
            <div class="form-form-wrap">
                <div class="form-container p-0">
                    <div class="form-content">
                        <h1 class="text-primary">
                            <i class="fa-light fa-book"></i>
                            CEOS
                        </h1>
                        {{-- FEEDBACKS --}}
                        @include('web.plataforma._template._components.feedback')

                        {{-- FORMULARIO --}}
                        @include('web.plataforma.sessao.login._includes._acesso.formulario')

                        {{-- TERMOS --}}
                        @include('web.plataforma.sessao.login._includes._acesso.termos')

                        {{-- VERSAO --}}
                        @include('web.plataforma.sessao.login._includes._acesso.versao')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
