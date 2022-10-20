$(document).on("click", ".excludeTask", function () {
    Swal.fire({
        title: 'Você tem certeza que deseja excluir a tarefa NOME_TAREFA?',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: `Não, cancelar`,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Faça a lógica da exclusão de tarefas!', '', 'success')
        }
    })
});