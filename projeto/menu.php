<?php
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
echo "<a href = 'inicio.php' style= 'color:gray;text-decoration:none;font-weight:bold;'HOME'</a>";
echo "<b><font color='gray'> | </font></br>";
echo "<a href = 'clientes.php' style= 'color:gray;text-decoration:none;font-weight:bold;'CLIENTES'</a>";
echo "<b><font color='gray'> | </font></br>";
echo "<a href = 'salgados.php' style= 'color:gray;text-decoration:none;font-weight:bold;'SALGADOS'</a>";
echo "<b><font color='gray'> | </font></br>";
echo "<a href = 'pedidos.php' style= 'color:gray;text-decoration:none;font-weight:bold;'HOME'</a>";
?>