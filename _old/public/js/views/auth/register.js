$(document).ready(function () {
  $('#dados-aluno').show();
  $('.cpf-responsavel').hide();
  $('#dados-professor').hide();

  $('#celular').mask('(99) 99999-9999');
  $('#telefone').mask('(99) 9999-9999');
  $('#cpf_responsavel').mask("999.999.999-99");

  $('#perfil').select2({ minimumResultsForSearch: Infinity });

  perfilOnChange($('#perfil').val());
  calcularIdadeAluno($('#data_nascimento').val());
});

function perfilOnChange(perfil) {
  if (perfil === 'aluno') {
    $('#dados-professor').hide();
    $('#dados-aluno').show();
  } else {
    $('#dados-aluno').hide();
    $('#dados-professor').show();
  }
}

function calcularIdadeAluno(dataNascimento) {
  if (/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/.test(dataNascimento)) {
    const diaMesAno = dataNascimento.split('-');

    dataNascimento = new Date();
    dataNascimento.setDate(diaMesAno[2]);
    dataNascimento.setMonth(diaMesAno[1] - 1);
    dataNascimento.setFullYear(diaMesAno[0]);

    const dataAtual = new Date();
    const idade = Math.floor(Math.ceil(Math.abs(dataNascimento.getTime() - dataAtual.getTime()) / (1000 * 3600 * 24)) / 365.25);

    $('.cpf-responsavel').hide();
    if (idade < 18) {
      $('.cpf-responsavel').show();
    }
  }
}