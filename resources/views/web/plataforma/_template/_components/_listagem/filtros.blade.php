@section('filtros_tabela')
    @isset($filtros)
        <aside class="filter-sidebar border-left">
            <form id="filtros">
                <div class="sidebar-chat" data-plugin="chat-sidebar">
                    <div class="sidebar-chat-info">
                        <h6 class="text-center">
                            <i class="fa-light fa-filter text-dark float-left"></i>
                            Filtros
                            <i class="fa-solid fa-times filter-sidebar-toggle float-right pr-2" style="cursor: pointer"></i>
                        </h6>
                        <hr>
                        <button type="button" class="btn btn-primary w-100 listar" data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Atualizar a tabela com as filtros selecionadas">
                            <i class="fa-light fa-magnifying-glass fa-lg mr-1"></i>
                            Listar
                        </button>
                        <hr>
                        <button type="button" class="btn btn-outline-secondary w-100 limpar_filtros" data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="Limpar todos os Filtros">
                            <i class="fa-light fa-filter-circle-xmark fa-lg mr-1"></i>
                            Limpar Filtros
                        </button>
                    </div>
                    <div class="chat-list mt-3">
                        <div class="list-group row">
                            @foreach ($filtros ?? [] as $nome => $filtro)
                                <div class="list-group-item pl-3"
                                    @isset($filtro['help'])
                                        data-container="body" data-toggle="popover" data-html="true" data-trigger="hover" data-placement="top" data-content="{{ $filtro['help'] }}"
                                    @endisset>

                                    <div class="form-group w-100 m-0">
                                        <label for="{{ $filtro['id'] ?? '' }}" class="font-weight-bold text-secondary">
                                            {{ $nome }}
                                        </label>

                                        @if ($filtro['type'] == 'text')
                                            <input type="text" class="{{ $filtro['class'] ?? '' }}" name="{{ $filtro['name'] }}" id="{{ $filtro['id'] ?? '' }}" placeholder="{{ $nome ?? '' }}">
                                        @endif

                                        @if ($filtro['type'] == 'select')
                                            <select class="{{ $filtro['class'] ?? '' }}" name="{{ $filtro['name'] }}" id="{{ $filtro['id'] ?? '' }}">
                                                @foreach ($filtro['options'] ?? [] as $option)
                                                    <option value="{{ $option['value'] }}" {{ $option['selected'] ? 'selected' : '' }}>
                                                        {{ $option['option'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </aside>
    @endisset
@endsection
