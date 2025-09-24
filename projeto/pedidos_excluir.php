<?php
include 'conecta.php';
$id=$_GET['id'];
$sql = "DELETE FROM pedidos where id=$id";
if (mysqli_query($conn, $sql)){
    "<script language='javascript' type='text/javascript'>
            window.location.href='pedidos.php'
            </script>";
}
?>