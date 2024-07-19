const selectInstituicao = $('#instituicao');
const selectCurso = $('#curso');
const selectDisciplina = $('#disciplina_id');

let disciplina = null;

$(document).ready(function () {
  selectInstituicao.change(onChangeInstituicao);
  selectCurso.change(onChangeCurso);

  if (selectInstituicao.val() === null) {
    selectInstituicao.append(`<option disabled selected>Nenhuma instituição encontrada</option>`);
    selectCurso.append(`<option disabled selected>Nenhum curso encontrado</option>`);
    selectDisciplina.append(`<option disabled selected>Nenhuma disciplina encontrada</option>`);
  }
});

function onChangeInstituicao(oldCursoId = null, oldDisciplinaId = null) {
  const instituicaoSelecionada = selectInstituicao.val();

  oldCursoId = Number.parseInt(oldCursoId);
  oldDisciplinaId = Number.parseInt(oldDisciplinaId);

  $.get(`/academico/instituicoes/${ instituicaoSelecionada }`, (instituicao) => {
    const textoSelectCurso = instituicao.cursos.length ? '[Selecionar Curso]' : 'Nenhum curso encontrado';

    selectCurso.empty();
    selectCurso.append(`<option disabled selected>${ textoSelectCurso }</option>`);

    $.each(instituicao.cursos, (indice, curso) => {
      selectCurso.append(`<option value="${ curso.id }"> ${ curso.nome } </option>`);
    });

    selectDisciplina.empty().append(`<option disabled selected>Nenhuma disciplina encontrada</option>`);

    if (oldCursoId) {
      selectCurso.val(oldCursoId).trigger('change');

      disciplina = oldDisciplinaId ? oldDisciplinaId : null;
    }
  });
}

function onChangeCurso() {
  const cursoSelecionado = selectCurso.val();

  selectDisciplina.empty();

  $.get(`/academico/cursos/${ cursoSelecionado }`, (curso) => {
    const textoSelectDisciplina = curso.disciplinas.length ? '[Selecionar Disciplina]' : 'Nenhuma disciplina encontrada';

    selectDisciplina.append(`<option disabled selected>${ textoSelectDisciplina }</option>`);

    $.each(curso.disciplinas, (indice, disciplina) => {
      selectDisciplina.append(`<option value="${ disciplina.id }"> ${ disciplina.nome } </option>`);
    });

    disciplina ? selectDisciplina.val(disciplina) : null;
    disciplina = null;
  });
}