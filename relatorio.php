<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="assets/css/alunos.css">

<section class="home-section">
    <div class="container">
        <div class="text">Relatório de Empréstimos de Chaves</div>

        <div class="table-responsive table-container">
            <table class="table table-striped" id="emprestimos-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Chave</th>
                        <th>Aluno</th>
                        <th>Data do Empréstimo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql = "SELECT * FROM emprestimos";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['chave_id']; ?></td>
                            <td><?php echo $row['aluno_cpf']; ?></td>
                            <td><?php echo $row['data_emprestimo']; ?></td>
                            <td>
                                <button class="btn btn-warning" data-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-key"></i> Devolver
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Função para deletar o registro de empréstimo
    $('.btn-delete').click(function () {
        var emprestimoId = $(this).data('id');
        
        // Exibir um alerta de confirmação antes de deletar
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você está prestes a excluir este registro de empréstimo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Se confirmado, enviar solicitação AJAX para excluir o registro
                $.ajax({
                    url: 'delete_emprestimo.php',
                    type: 'POST',
                    data: { id: emprestimoId },
                    success: function (response) {
                        // Se a exclusão for bem-sucedida, recarregar a página
                        window.location.reload();
                    },
                    error: function () {
                        // Se houver um erro, exibir mensagem de erro
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo deu errado! Não foi possível excluir o registro.',
                        });
                    }
                });
            }
        });
    });
</script>
