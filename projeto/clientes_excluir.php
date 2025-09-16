<?php
include 'conecta.php';
$id=$_GET['id'];
$sql = "DELETE FROM clientes where id=$id";
if (mysqli_query($conn, $sql)){
    "<script language='javascript' type='text/javascript'>
            window.location.href='clientes.php'
            </script>";
}
?>