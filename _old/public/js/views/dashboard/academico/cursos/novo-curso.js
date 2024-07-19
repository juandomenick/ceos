$(document).ready(function () {
  $('#novo-coordenador').show();
  $('#selecionar-coordenador').hide();

  $('#coordenador_celular').mask('(99) 99999-9999');
  $('#coordenador_telefone').mask('(99) 9999-9999');

  $('#nivel').select2();
  $('#ativo').select2();
  $('#tipo-cadastro').select2();
  $('#instituicao').select2();
  $('#coordenador_id').select2();
});

function tipoCadastro(tipo) {
  if (tipo === 'novo-coordenador') {
    $('#titulo').text('Dados do Coordenador');
    $('#novo-coordenador').show();
    $('#selecionar-coordenador').hide();
  } else if (tipo === 'selecionar-coordenador') {
    $('#novo-coordenador input').val("");
    $('#titulo').text('Selecionar Coordenador');
    $('#novo-coordenador').hide();
    $('#selecionar-coordenador').show();
  }
}

function carregarCoordenadores(instituicaoId, coordenadores, coordenadorAnteriorId) {
  if (instituicaoId) {
    const selectElement = $('select[name=coordenador_id]');

    selectElement.empty();
    selectElement.append(`<option selected disabled>[Selecionar Coordenador]</option>`);

    coordenadores = typeof coordenadores  === 'string' ? JSON.parse(coordenadores) : coordenadores;

    $.each(coordenadores, function (indice, coordenador) {
      let naoEhDiretorNemAdministrador = true;

      $.each(coordenador.user.roles, function (indice, role) {
        if (role.name === 'diretor' || role.name === 'administrador') {
          naoEhDiretorNemAdministrador = false;
        }
      });

      if (coordenador.instituicao_id === Number.parseInt(instituicaoId) && naoEhDiretorNemAdministrador) {
        const opcaoSelecionada = Number.parseInt(coordenadorAnteriorId) === coordenador.id ? 'selected' : '';

        selectElement
          .append(`<option value='${ coordenador.id }' ${ opcaoSelecionada }>${ coordenador.user.nome }</option>`);
      }
    });
  }
}