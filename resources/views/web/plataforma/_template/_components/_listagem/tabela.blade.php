@isset($id_tabela)
    <div class="row" id="div-{{ $id_tabela }}">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="{{ $id_tabela }}">
                                    <thead class="w-100">
                                        <tr></tr>
                                    </thead>
                                    <tfoot class="w-100">
                                        <tr></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endisset
