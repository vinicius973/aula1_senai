<?php
    session_start();
    include 'conecta.php';
    if (!isset($_SESSION["user"])) {
        echo "<script language='javascript' type='text/javascript'>
        window.location.href='index.php';
        </script>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="content-language" content="pt-br">
        <title>SALGADOS DA MAMÃE</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <style>
            body {
                padding: 5px;
                margin: 5px;
            }
            h2 {
                color: gray;
            }
            .main-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 10px;
            }
            .user-info {
                display: flex;
                align-items: center;
                gap: 8px;
                color: gray;
            }
            .username {
                font-weight: bold;
            }
            .logout-link {
                color: red;
                font-weight: bold;
                text-decoration: none;
            }
            .logout-link:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <header class="main-header">
            <h2>SALGADINHOS DA MAMÃE</h2>
            <div class="user-info">
                <?php
                    if (!empty($_SESSION["user"])) {
                        $usuario = $_SESSION["user"];
                        echo "<span class='username'>".htmlspecialchars($usuario)." | </span><a class='logout-link' href='sair.php'>SAIR</a>";
                    }
                ?>
            </div>
        </header>
        <hr>
        <nav>
            <?php
                include 'menu.php';
            ?>
        </nav>
        <br>
        <center><h2><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="gray" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg>&nbsp;PEDIDOS</h2></center>
        <br>
        <br>
        <?php
            $id = $_GET['id'];
            $pesquisa = mysqli_query($conn, "select pedidos.id AS idpedido, pedidos.id_cliente, pedidos.data_pedido, pedidos.data_entrega, pedidos.total, clientes.id, clientes.nome AS nomecliente, salgados.id, salgados.nome AS salgadonome, pedidos_salgados.quantidade from pedidos, pedidos_salgados, clientes, salgados WHERE pedidos.id = pedidos_salgados.id_pedido AND pedidos.id_cliente = clientes.id AND pedidos_salgados.id_salgado = salgados.id AND pedidos.id = $id;");
            $row = mysqli_num_rows($pesquisa);
            if ($row > 0) {
                while ($registro = $pesquisa -> fetch_array()) {
                    $id = $registro['idpedido'];
                    $nomecliente = $registro['nomecliente'];
                    $nomesalgado = $registro['salgadonome'];
                    $quantidade = $registro['quantidade'];
                    $data_pedido = $registro['data_pedido'];
                    $data_entrega = $registro['data_entrega'];
                    $total = $registro['total'];
                }
            } else {
                echo mysqli_error();
            }
        ?>
        <div class="row justify-content-center row-cols-1 row-cols-md-2 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sw">
                    <div class="card-header py-3">
                        <h2>PEDIDO Nº <?php echo $id; ?></h2>
                    </div>
                    <div class="card-body text-start">
                        <b>CLIENTE:</b>&nbsp;<?php echo $nomecliente; ?>
                        <br/>
                        <b>DATA DO PEDIDO:</b>&nbsp;<?php echo date("d/m/Y", strtotime($data_pedido)); ?>
                        <br/>
                        <b>DATA DA ENTREGA:</b>&nbsp;<?php echo date("d/m/Y", strtotime($data_entrega)); ?>
                        <br/>
                        <hr/>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">SALGADO</th>
                                    <th scope="col">QUANTIDADE</th>
                                    <th scope="col">SUBTOTAL R$</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        $pesquisa = mysqli_query($conn, "select salgados.id, salgados.nome, pedidos_salgados.id_salgado, pedidos_salgados.quantidade, pedidos_salgados.subtotal from salgados, pedidos_salgados WHERE pedidos_salgados.id_pedido=$id AND salgados.id = pedidos_salgados.id_salgado;");
                                        $row = mysqli_num_rows($pesquisa);
                                        if ($row > 0) {
                                            while ($registro = $pesquisa -> fetch_array()) {
                                                echo '<td>'.$registro['nome'].'</td>';
                                                echo '<td>'.$registro['quantidade'].'</td>';
                                                echo '<td>'.$registro['subtotal'].'</td>';
                                                echo '</tr>';
                                            }
                                        } 
                                    ?>
                            </tbody>
                        </table>
                        <br/>
                        <hr/>
                        <b>TOTAL:</b>&nbsp;R$ <?php echo $total; ?>
                        <br/>
                        <br/>
                        <a href="pedidos.php" class="btn btn-success" role="button">VOLTAR</a>
                    </div>
                </div>       
            </div>
        </div>
    </body>
</html>