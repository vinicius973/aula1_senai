<?php
    include 'conecta.php';
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $genero = $_POST['genero'];
    $numero = $_POST['numero'];
    $query = $conn->query("SELECT * FROM usuarios WHERE nome='$nome'");
    if (mysqli_num_rows($query) > 0) {
        echo "<script language='javascript' type='text/javascript'>
        alert('Cliente já existe em nossa base de dados!');
        window.location.href='usuario.php';</script>";
        exit();
    } else {
        $sql = "INSERT INTO usuarios(nome,idade,genero,numero) VALUES ('$nome','$idade','$genero')";
        if (mysqli_query($conn, $sql)) {
            echo "<script language='javascript' type='text/javascript'>
            window.location.href='usuario.php'
            </script>";
        } else {
            echo "<script language='javascript' type='text/javascript'>
            alert('Não foi possível cadastrar o cliente!');
            window.location.href='usuario.php';</script>";
        }
    }
    mysqli_close($conn);
?>