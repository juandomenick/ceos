const selectInstituicao = $('#instituicao');
const selectCurso = $('#curso');
const selectDisciplina = $('#disciplina_id');
const selectProfessor = $('#professor_id');
const selectAtivo = $('#ativo');
const selectAlunos = $('#alunos');

let disciplina = null;
let professor = null;

$(document).ready(function () {
  selectInstituicao.change(onChangeInstituicao);
  selectCurso.change(onChangeCurso);
});

function onChangeInstituicao(oldCursoId = null, oldDisciplinaId = null, oldProfessorId = null) {
  const instituicaoSelecionada = selectInstituicao.val();

  oldCursoId = Number.parseInt(oldCursoId);
  oldDisciplinaId = Number.parseInt(oldDisciplinaId);
  oldProfessorId = Number.parseInt(oldProfessorId);

  $.get(`/academico/instituicoes/${ instituicaoSelecionada }`, (instituicao) => {
    const textoSelectCurso = instituicao.cursos.length ? '[Selecionar Curso]' : 'Nenhum curso encontrado';

    selectCurso.empty();
    selectCurso.append(`<option disabled selected>${ textoSelectCurso }</option>`);

    $.each(instituicao.cursos, (indice, curso) => {
      selectCurso.append(`<option value="${ curso.id }"> ${ curso.nome } </option>`);
    });

    selectDisciplina.empty().append(`<option disabled selected>Nenhuma disciplina encontrada</option>`);
    selectProfessor.empty().append(`<option disabled selected>Nenhum professor encontrado</option>`);
    
    if (oldCursoId) {
      selectCurso.val(oldCursoId).trigger('change');

      disciplina = oldDisciplinaId ? oldDisciplinaId : null;
      professor = oldProfessorId ? oldProfessorId : null;
    }
  });
}

function onChangeCurso() {
  const cursoSelecionado = selectCurso.val();

  selectDisciplina.empty();
  selectProfessor.empty();

  $.get(`/academico/cursos/${ cursoSelecionado }`, (curso) => {
    const textoSelectDisciplina = curso.disciplinas.length ? '[Selecionar Disciplina]' : 'Nenhuma disciplina encontrada';
    const textoSelectProfessor = curso.professores.length ? '[Selecionar Professor]' : 'Nenhum professor encontrado';

    selectDisciplina.append(`<option disabled selected>${ textoSelectDisciplina }</option>`);
    selectProfessor.append(`<option disabled selected>${ textoSelectProfessor }</option>`);

    $.each(curso.disciplinas, (indice, disciplina) => {
      selectDisciplina.append(`<option value="${ disciplina.id }"> ${ disciplina.nome } </option>`);
    });

    $.each(curso.professores, (indice, professor) => {
      selectProfessor.append(`<option value="${ professor.id }"> ${ professor.user.nome } </option>`);
    });

    disciplina ? selectDisciplina.val(disciplina) : null;
    professor ? selectProfessor.val(professor) : null;

    disciplina = professor = null;
  });
}