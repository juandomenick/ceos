$(document).ready(function() {
  $('#data-tables').DataTable();
  $('#ativo').select2({ minimumResultsForSearch: Infinity });

  $('#celular').mask('(99) 99999-9999');
  $('#telefone').mask('(99) 9999-9999');
});

/**
 * Função universal a todos os CRUDS do dashboard para deletar recursos.
 */
function deletarRecurso(csrfToken, rota, nomeRecurso = 'Recurso') {
  Swal.fire({
    icon: 'question',
    title: `Deletar ${ nomeRecurso }`,
    text: 'Essa ação será irreversível. Você tem certeza que deseja deletar esse recurso?',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    confirmButtonText: 'Sim, deletar!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: rota,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        data: {
          _method: 'DELETE'
        },
        complete: function (response) {
          if(response.responseJSON && response.responseJSON.redirect) {
            location.href = response.responseJSON.redirect
          } else {
            location.reload();
          }
        }
      });
    }
  });
}

/**
 * Função para carregar select com estados brasileiros.
 */
function carregarEstados(idEstadoAnterior, idCidadeAnterior = null) {
  $.get('/estados', function (estados) {
    $('select[name=estados]').empty();

    $.each(estados.data, function (indice, estado) {
      const opcaoSelecionada = Number.parseInt(idEstadoAnterior) === estado.id ? 'selected' : '';

      $('select[name=estados]').append(`<option value='${ estado.id }' ${ opcaoSelecionada }>${ estado.nome }</option>`);

      if (indice === 0 && !idEstadoAnterior) {
        carregarCidades(estado.id);
      }
    });

    if (idEstadoAnterior) {
      idCidadeAnterior ? carregarCidades(idEstadoAnterior, idCidadeAnterior) : carregarCidades(idEstadoAnterior);
    }
  });
}

/**
 * Função para carregar select com cidades brasileiras a partir do id de um estado específico
 */
function carregarCidades(idEstado, idCidadeAnterior = null) {
  $.get(`/estados/${ idEstado }/cidades`, function (cidades) {
    $('select[name=cidades]').empty();

    $.each(cidades.data, function (indice, cidade) {
      const opcaoSelecionada = Number.parseInt(idCidadeAnterior) === cidade.id ? 'selected' : '';

      $('select[name=cidades]').append(`<option value='${ cidade.id }' ${ opcaoSelecionada }>${ cidade.nome }</option>`);
    });
  });
}