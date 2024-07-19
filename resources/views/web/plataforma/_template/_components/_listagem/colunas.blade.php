@section('colunas_tabela')
    @isset($colunas)
        <aside class="column-sidebar border-left">
            <form id="colunas">
                <div class="sidebar-chat" data-plugin="chat-sidebar">
                    <div class="sidebar-chat-info">
                        <h6 class="text-center">
                            <i class="fa-light fa-table-list text-dark float-left"></i>
                            Colunas
                            <i class="fa-solid fa-times column-sidebar-toggle float-right pr-2" style="cursor: pointer"></i>
                        </h6>
                        <hr>
                        <button type="button" class="btn btn-primary w-100 listar" data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Atualizar a tabela com as filtros selecionadas">
                            <i class="fa-light fa-magnifying-glass fa-lg mr-1"></i>
                            Listar
                        </button>
                        <hr>
                        <button type="button" class="btn btn-info w-100 marcar_colunas" data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Marcar todas as colunas">
                            <i class="fa-solid fa-square-check fa-lg mr-1"></i>
                            Marcar Todos
                        </button>
                    </div>
                    <div class="chat-list mt-3">
                        <div class="list-group row">
                            @foreach ($colunas ?? [] as $nome => $coluna)
                                <div class="list-group-item pl-3">
                                    <input type="checkbox" class="i-checks colunas" name="{{ $coluna['name'] }}" id="Colunas_{{ $coluna['value'] }}" value="{{ $coluna['value'] }}" checked>
                                    <label class="name m-0 pl-2 d-inline" for="Colunas_{{ $coluna['name'] }}">
                                        {{ $nome }}
                                        @if ($coluna['name'] == 'Base[CodigoSistema]')
                                            <span data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Caso estiver desmarcado, os botões não serão carregados">
                                                <i class="fa-light fa-circle-exclamation text-danger ml-1"></i>
                                            </span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </aside>
    @endisset
@endsection
