<?php
include("conexion.php");
session_start(); // <--- Inicia la sesión

$correo = $_POST['correo'];
$clave = $_POST['clave'];
$rol = $_POST['rol'];

// Usa consultas preparadas para mayor seguridad
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ? AND rol = ?");
$stmt->bind_param("ss", $correo, $rol);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($clave, $usuario['clave'])) {
        // Guarda datos de sesión
        $_SESSION['usuario'] = $usuario['nombre']; // o el campo que uses como nombre/usuario
        $_SESSION['rol'] = $usuario['rol'];
        
        // Redirecciona según el rol
        if ($rol == "administrador") {
            header("Location: ../admin/dashboard_admin.php");
        } else {
            header("Location: ../cliente/dashboard_cliente.php");
        }
        exit;
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado o rol incorrecto.";
}
?>
