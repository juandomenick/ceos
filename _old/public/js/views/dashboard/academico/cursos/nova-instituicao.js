$(document).ready(function () {
  $('#novo-diretor').show();
  $('#selecionar-diretor').hide();

  $('#diretor_telefone').mask('(99) 9999-9999');
  $('#diretor_celular').mask('(99) 99999-9999');

  $('#tipo-cadastro').select2({ minimumResultsForSearch: Infinity });
  $('#diretor_id').select2();
  $('#estados').select2();
  $('#cidades').select2();
});

function tipoCadastro(tipo) {
  if (tipo === 'novo-diretor') {
    $('#titulo').text('Dados do Diretor');
    $('#novo-diretor').show();
    $('#selecionar-diretor').hide();
  } else if (tipo === 'selecionar-diretor') {
    $('#titulo').text('Selecionar Diretor');
    $('#novo-diretor').hide();
    $('#selecionar-diretor').show();
  }
}