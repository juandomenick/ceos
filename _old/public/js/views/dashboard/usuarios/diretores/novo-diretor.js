$(document).ready(function () {
  $('#novo-diretor').show();
  $('#promover-professor').hide();

  $('#tipo-cadastro').select2({
    minimumResultsForSearch: Infinity
  });
  $('#professor').select2();
});

function tipoCadastro(tipo) {
  if (tipo === 'novo-diretor') {
    $('#titulo').text('Novo Diretor');
    $('#novo-diretor').show();
    $('#promover-professor').hide();
  } else if (tipo === 'promover-professor') {
    $('#titulo').text('Promover Professor');
    $('#novo-diretor').hide();
    $('#promover-professor').show();
  }
}