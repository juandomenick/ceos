@section('ordem_tabela')
    @isset($ordem)
        <aside class="order-sidebar border-left">
            <form id="ordenacao">
                <div class="sidebar-chat" data-plugin="chat-sidebar">
                    <div class="sidebar-chat-info">
                        <h6 class="text-center">
                            <i class="fa-light fa-arrow-down-wide-short text-dark float-left"></i>
                            Ordenação
                            <i class="fa-solid fa-times order-sidebar-toggle float-right pr-2" style="cursor: pointer"></i>
                        </h6>
                        <hr>
                        <button type="button" class="btn btn-primary w-100 listar" data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Atualizar a tabela com as colunas selecionadas">
                            <i class="fa-light fa-magnifying-glass fa-lg mr-1"></i>
                            Listar
                        </button>
                        <hr>
                        <select class="form-control select2" name="Ordem">
                            <option value="DESC">Decrescente / Não-Alfabético</option>
                            <option value="ASC">Crescente / Alfabético</option>
                        </select>
                    </div>
                    <div class="chat-list mt-3">
                        <div class="list-group row">
                            @foreach ($ordem ?? [] as $nome => $valor)
                                <div class="list-group-item pl-3">
                                    <input type="radio" class="i-checks" name="Campo" id="Campo_{{ $valor }}" value="{{ $valor }}" {{ $loop->first ? 'checked' : '' }}>
                                    <label class="name m-0 pl-2" for="Campo_{{ $valor }}">{{ $nome }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </aside>
    @endisset
@endsection
