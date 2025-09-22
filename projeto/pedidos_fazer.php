<?php
session_start();
include 'conecta.php';
if(!isset($_SESSION['user'])){
    echo "<script language='javascript' type= 'text/javascript'> 
    window.location.href='index.php';
    </script>";
}
?>