<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    echo "<a href='inicio.php' style='color:gray;text-decoration:none;font-weight:bold;'>HOME</a>";
    echo "<b><font color='gray'> | </font></b>";
    echo "<a href='usuario.php' style='color:gray;text-decoration:none;font-weight:bold;'>USUARIO</a>";
    echo "<b><font color='gray'> | </font></b>";
  