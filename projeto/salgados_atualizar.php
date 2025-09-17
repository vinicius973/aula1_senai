<?php
    include 'conecta.php';
    $id = $_GET['id'];
    $salgado_nome = $_POST['nome'];
    $salgado_tipo = $_POST['tipo'];

    $salgado_valor = $_POST['valor'];
 ;
    $sql = "UPDATE clientes SET nome=?,tipo=?,valor=? WHERE id=?";
    $stmt = $conn->prepare($sql) or die($conn->error);
    if (!$stmt) {
        echo "Erro na atualização: ".$conn->error;
    }
    $stmt->bind_param('sssisssi', $salgado_nome,$salgado_tipo,$salgado_valor,$id);
    $stmt->execute();
    $conn->close();
    echo "<script language='javascript' type='text/javascript'>
    window.location.href='salgados.php'
    </script>";
?>