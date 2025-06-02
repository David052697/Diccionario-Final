<?php
include("../includes/conexion.php");

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$imagen = $_FILES['imagen']['name'];
$tmp = $_FILES['imagen']['tmp_name'];

$directorioDestino = __DIR__ . '/../img/'; // Ruta absoluta más segura

// Crear carpeta si no existe (opcional pero útil)
if (!is_dir($directorioDestino)) {
    mkdir($directorioDestino, 0755, true);
}

// Mover la imagen al destino
if (move_uploaded_file($tmp, $directorioDestino . $imagen)) {
    $sql = "INSERT INTO palabras (titulo, descripcion, imagen) VALUES ('$titulo', '$descripcion', '$imagen')";
    $conexion->query($sql);
    header("Location: dashboard_admin.php");
    exit;
} else {
    echo "Error al subir la imagen.";
}
?>
