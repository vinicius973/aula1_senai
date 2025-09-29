<?php
session_start();
include 'conecta.php';
$sql = "SELECT count(*) from pedidos";
echo ("<script>window.location.replace('inicio.php');</script>");
?>