@extends('dashboard.dashboard', ['classesIcone' => 'fa fa-user-tie', 'tituloPagina' => 'Diretores'])

@section('dashboard-content')
  <form action="{{ route('diretores.update', $diretor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Editar Diretor</h5>
      </div>

      <div class="card-body">
        @include('layouts.geral.alert')

        <div class="row">
          <div class="col-md-12 col-lg-6">
            @input(['name' => 'nome', 'label' => 'Nome', 'value' => $diretor->nome])

            <div class="row">
              @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'value' => $diretor->email, 'readonly' => true])
              @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'usuario', 'label' => 'Usuário', 'value' => $diretor->usuario])
            </div>

            <div class="row">
              @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'celular', 'label' => 'Celular', 'value' => $diretor->celular])
              @input(['cols' => 'col-md-12 col-lg-6', 'name' => 'telefone', 'label' => 'Telefone', 'value' => $diretor->telefone])
            </div>
          </div>

          <div class="col-md-12 col-lg-6">
            <fieldset>
              <legend>Instituições</legend>

              <table class="table table-striped mt-2">
                <thead>
                  <tr>
                    <th>Sigla</th>
                    <th>Cidade</th>
                    <th>Status</th>
                  </tr>
                </thead>

                <tbody>
                  @forelse($diretor->instituicoes as $instituicao)
                    <tr>
                      <td>{{ $instituicao->sigla }}</td>
                      <td>{{ $instituicao->cidade->nome }} - {{ $instituicao->cidade->estado->uf }}</td>

                      <td>
                          <span class="badge {{ $instituicao->ativo ? "badge-success" : "badge-danger" }}">
                            {{ $instituicao->ativo ? "Ativo" : "Inativo" }}
                          </span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3">Nenhuma instituição encontrada</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </fieldset>
          </div>
        </div>
      </div>

      <div class="card-footer">
        @button(["type" => 'primary', 'icon' => 'fa fa-arrow-left', 'text' => 'Voltar', 'route' => ['diretores.index']])
        @button(['type' => 'success', 'classes' => 'float-right', 'icon' => 'fas fa-save', 'iconClasses' => 'mr-1', 'text' => 'Salvar'])
      </div>
    </div>
  </form>
@endsection