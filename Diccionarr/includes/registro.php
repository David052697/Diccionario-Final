<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

$sql = "INSERT INTO usuarios (nombre, correo, clave, rol) VALUES ('$nombre', '$correo', '$clave', '$rol')";
if ($conexion->query($sql) === TRUE) {
    header("Location: ../login.html");
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}
?>