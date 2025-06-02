<?php
$host = "db";             
$usuario = "user";
$contrasena = "password";
$baseDeDatos = "diccionario";

$conexion = new mysqli($host, $usuario, $contrasena, $baseDeDatos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
