<?php
    include 'conecta.php';
  
    $salgado_nome = $_POST['nome'];
    $salgado_tipo = $_POST['tipo'];
    $salgado_valor = $_POST['valor'];
   
    $query = $conn->query("SELECT * FROM salgados WHERE nome='$salgado_nome' AND tipo='$salgado_tipo'");
    if (mysqli_num_rows($query) > 0) {
        echo "<script language='javascript' type='text/javascript'>
        alert('Salgado já existe em nossa base de dados!');
        window.location.href='salgados.php';</script>";
        exit();
    } else {
        $sql = "INSERT INTO salgados(nome,tipo,valor,) VALUES ('$salgado_nome','$salgado_tipo','$salgado_valor')";
        if (mysqli_query($conn, $sql)) {
            echo "<script language='javascript' type='text/javascript'>
            window.location.href='salgados.php'
            </script>";
        } else {
            echo "<script language='javascript' type='text/javascript'>
         
            window.location.href='salgados.php';</script>";
        }
    }
    mysqli_close($conn);
?>