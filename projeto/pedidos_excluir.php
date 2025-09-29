<?php
    include 'conecta.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM pedidos_salgados WHERE id_pedido=$id";
    $sql_pedidos = "DELETE FROM pedidos WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        if (mysqli_query($conn, $sql_pedidos)) {
            echo "<script language='javascript' type='text/javascript'>
            window.location.href='pedidos.php'
            </script>";
        }
    }
    else {
        echo mysqli_error();
    }
    mysqli_close($conn);
?>