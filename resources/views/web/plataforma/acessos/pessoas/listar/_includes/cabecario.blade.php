<div class="row">
    <div class="col-lg-12">
        <div class="widget-content widget-content-area">
            <div class="row justify-content-end align-items-center w-100 m-0">
                <div class="col-lg-8 pl-0">
                    @include('web.plataforma._template._components._listagem.acoes')
                </div>
                <div class="col-lg-2">
                    <a href="{{ route('web.plataforma.acessos.pessoas.cadastrar') }}" class="btn btn-secondary w-100 m-1" id="Cadastrar" data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Acessar tela de cadastro de um novo <strong>Usuário</strong>">
                        <i class="fa-light fa-circle-plus fa-lg mr-1"></i>
                        Cadastrar
                    </a>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary w-100 m-1 listar" id="Listar" data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Listar <strong>Usuários</strong> conforme os Filtros, Colunas e Ordem selecionados">
                        <i class="fa-light fa-search fa-lg mr-1"></i>
                        Listar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

