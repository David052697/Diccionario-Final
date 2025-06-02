<?php
session_start();           // Inicia la sesión para poder destruirla
session_unset();           // Limpia todas las variables de sesión
session_destroy();         // Destruye la sesión

header("Location: ../index.html");  // Redirige a index.html
exit();                    // Asegura que se detenga la ejecución aquí
?>
