$(document).ready(function () {
  $('#instituicao').select2();
  $('#curso_id').select2();
  $('#ativo').select2();
});

function carregarCursos(instituicaoId, cursos, cursoAnteriorId) {
  if (instituicaoId) {
    const selectElement = $('select[name=curso_id]');

    selectElement.empty();
    selectElement.append(`<option selected disabled>[Selecionar Curso]</option>`);

    $.each(cursos, function (indice, curso) {
      if (curso.instituicao_id === Number.parseInt(instituicaoId)) {
        const opcaoSelecionada = Number.parseInt(cursoAnteriorId) === curso.id ? 'selected' : '';

        selectElement.append(`<option value='${ curso.id }' ${ opcaoSelecionada }>${ curso.sigla }</option>`);
      }
    });
  }
}