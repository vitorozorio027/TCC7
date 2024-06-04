<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="assets/css/alunos.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<section class="home-section">
    <div class="container">
        <div class="text">Empréstimo de Chaves</div>

        <form action="process.php" method="POST">
            <div class="form-group">
                <label for="chave-id">ID da Chave</label>
                <select id="chave-id" name="chave_id" class="form-control" required>
                    <option value="">Selecione a Chave</option>
                    <?php
                    include 'db.php';
                    $sql = "SELECT id FROM chaves";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()):
                        echo '<option value="'.$row['id'].'">'.$row['id'].'</option>';
                    endwhile;
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="aluno-cpf">CPF do Aluno</label>
                <select id="aluno-cpf" name="aluno_cpf" class="form-control" required>
                    <option value="">Selecione o CPF do Aluno</option>
                    <?php
                    $sql = "SELECT cpf FROM alunos";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()):
                        echo '<option value="'.$row['cpf'].'">'.$row['cpf'].'</option>';
                    endwhile;
                    ?>
                </select>
            </div>

            <div id="aluno-info" style="display: none;">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="matricula">Matrícula</label>
                    <input type="text" id="matricula" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="turma">Turma</label>
                    <input type="text" id="turma" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control" readonly>
                </div>
            </div>

            <button type="submit" name="add_emprestimo" class="btn btn-primary">Registrar Empréstimo</button>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#aluno-cpf').on('change', function () {
            var cpf = $(this).val();
            if (cpf) {
                $.ajax({
                    url: 'get_aluno.php',
                    type: 'GET',
                    data: { cpf: cpf },
                    success: function (data) {
                        var aluno = JSON.parse(data);
                        if (aluno) {
                            $('#nome').val(aluno.nome);
                            $('#matricula').val(aluno.matricula);
                            $('#turma').val(aluno.turma);
                            $('#telefone').val(aluno.telefone);
                            $('#email').val(aluno.email);
                            $('#aluno-info').show();
                        }
                    }
                });
            } else {
                $('#aluno-info').hide();
                $('#nome').val('');
                $('#matricula').val('');
                $('#turma').val('');
                $('#telefone').val('');
                $('#email').val('');
            }
        });
    });
</script>
