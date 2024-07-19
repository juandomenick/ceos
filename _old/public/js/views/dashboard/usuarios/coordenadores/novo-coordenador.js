$(document).ready(function () {
  $('#novo-coordenador').show();
  $('#promover-professor').hide();

  $('#tipo-cadastro').select2({
    minimumResultsForSearch: Infinity
  });
  $('#professor').select2();
  $('#instituicao').select2();
});

function tipoCadastro(tipo) {
  if (tipo === 'novo-coordenador') {
    $('#titulo').text('Novo Coordenador');
    $('#novo-coordenador').show();
    $('#promover-professor').hide();
  } else if (tipo === 'promover-professor') {
    $('#titulo').text('Promover Professor');
    $('#novo-coordenador').hide();
    $('#promover-professor').show();
  }
}