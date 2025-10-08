<?php
session_start();
include 'conecta.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

// Primeiro verifica se é admin da SEJUC
$sql_admin = "SELECT * from usu_sejuc where email='$email' and senha='$senha'";
$result_admin = mysqli_query($conn, $sql_admin);
if (mysqli_num_rows($result_admin) > 0) {
    $admin = mysqli_fetch_assoc($result_admin);
    $_SESSION['usuario_id'] = $admin['id'];
    $_SESSION['usuario_nome'] = $admin['nome'];
    $_SESSION['usuario_tipo'] = 'admin';

    // Redireciona para o dashboard
    echo "<script>window.location.replace('dashboard.php');</script>";
    exit;
}

// Se não for admin, verifica se é jovem
$sql_admin = "SELECT * from usu_jovem where email='$email' and senha='$senha'";
$result_jovem = mysqli_query($conn, $sql_jovem);

if (mysqli_num_rows($result_jovem) > 0) {
    $jovem = mysqli_fetch_assoc($result_jovem);
    $_SESSION['usuario_id'] = $jovem['id'];
    $_SESSION['usuario_nome'] = $jovem['nome'];
    $_SESSION['usuario_tipo'] = 'jovem';

    // Redireciona para a página inicial dos jovens
    echo "<script>window.location.replace('inicio.php');</script>";
    exit;
}

// Caso não encontre em nenhum dos dois
echo "<script>alert('Email ou senha inválidos!'); window.location.replace('index.php');</script>";

mysqli_close($conn);
?>

