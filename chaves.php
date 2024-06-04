<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="assets/css/alunos.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<section class="home-section">
    <div class="container">
        <div class="text">Cadastro de Chaves</div>

        <div class="row">
            <div class="col-md-6">
                <input type="text" id="search-input" placeholder="Pesquisar chaves..." class="form-control">
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#addModal">
                    + NOVO
                </button>
            </div>
        </div>

        <div class="table-responsive table-container">
            <table class="table table-striped" id="chaves-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prateleira</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql = "SELECT * FROM chaves";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['prateleira']; ?></td>
                            <td class="actions">
                                <a href="#" class="btn btn-success edit-btn" data-toggle="modal" data-target="#editModal"
                                    data-id="<?php echo $row['id']; ?>" data-prateleira="<?php echo $row['prateleira']; ?>">Editar</a>
                                <a href="process.php?delete_chave=<?php echo $row['id']; ?>" class="btn btn-danger">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal de Adição -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Adicionar Chave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="process.php" method="POST">
                    <div class="input-group">
                        <label for="add-prateleira">Prateleira</label>
                        <input type="text" name="prateleira" id="add-prateleira" required>
                    </div>
                    <button type="submit" name="add_chave" class="btn btn-primary">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Chave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="process.php" method="POST">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="input-group">
                        <label for="edit-prateleira">Prateleira</label>
                        <input type="text" name="prateleira" id="edit-prateleira" required>
                    </div>
                    <button type="submit" name="update_chave" class="btn btn-primary">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const msg = urlParams.get('msg');

        if (msg === 'success_chave') {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Chave adicionada com sucesso!',
                confirmButtonText: 'OK'
            });
        } else if (msg === 'updated_chave') {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Chave atualizada com sucesso!',
                confirmButtonText: 'OK'
            });
        } else if (msg === 'deleted_chave') {
            Swal.fire({
                icon: 'error',
                title: 'Deletado!',
                text: 'Chave deletada com sucesso!',
                confirmButtonText: 'OK'
            });
        }

        $('.edit-btn').click(function () {
            var id = $(this).data('id');
            var prateleira = $(this).data('prateleira');

            $('#edit-id').val(id);
            $('#edit-prateleira').val(prateleira);
        });

        $('#search-input').on('keyup', function () {
            var value = $(this).val().toLowerCase();
            $('#chaves-table tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
