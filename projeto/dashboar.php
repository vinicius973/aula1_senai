<?php
session_start();
include 'conecta.php';
echo ("<script>window.location.replace('inicio.php');</script>");
?>
<DOCTYPE html>
<div class="row justify-content-center row-cols-1 row-cols-md-2 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sw">
                    <div class="card-header py-3">
                        <h2>CLIENTES CADASTRADOS</h2>
                    </div>
                    <div class="card-body text-start">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">NOME</th>
                                    <th scope="col">CELULAR</th>
                                    <th scope="col">CIDADE</th>
                                    <th scope="col">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        $pesquisa = mysqli_query($conn, "SELECT * FROM clientes ORDER BY nome");
                                        $row = mysqli_num_rows($pesquisa);
                                        if ($row > 0) {
                                            while ($registro = $pesquisa -> fetch_array()) {
                                                $id = $registro['id'];
                                                $nome = $registro['nome'];
                                                $celular = $registro['celular'];
                                                $cidade = $registro['cidade'];
                                                echo '<td>'.$nome.'</td>';
                                                echo '<td>'.$celular.'</td>';
                                                echo '<td>'.$cidade.'</td>';
                                                echo '<td><a href="clientes_editar.php?id='.$id.'"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                </svg></a> | <a href="clientes_excluir.php?id='.$id.'"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                </svg></a></td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo "NÃO HÁ CLIENTES CADASTRADOS!";
                                        }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>       
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CADASTRO DE CLIENTE</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="clientes_cadastro.php" method="POST">
                            <div class="form-group">
                                <label>NOME DO CLIENTE</label>
                                <input type="text" class="form-control" name="nome" required>
                                <br>
                                <label>CELULAR</label>
                                <input type="number" class="form-control" name="celular" required>
                                <br>
                                <label>ENDEREÇO</label>
                                <input type="text" class="form-control" name="endereco" required>
                                <br>
                                <label>NÚMERO</label>
                                <input type="number" class="form-control" name="numero" required>
                                <br>
                                <label>COMPLEMENTO</label>
                                <input type="text" class="form-control" name="complemento" required>
                                <br>
                                <label>CIDADE</label>
                                <input type="text" class="form-control" name="cidade" required>
                                <br>
                                <label>CPF</label>
                                <input type="number" class="form-control" name="cpf" required>
                                <br>
                                <button type="submit" class="btn btn-success">CADASTRAR</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">FECHAR</button>
                    </div>
                </div>
            </div>
    </div>
</html>
