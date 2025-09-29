<?php
session_start();
include 'conecta.php';
 $sql = "SELECT count(*) FROM clientes";
 echo ("<script>window.location.replace('inicio.php');</script>");
?>