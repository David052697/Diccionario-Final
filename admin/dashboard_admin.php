<?php
session_start();
include("../includes/conexion.php");

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header("Location: ../login.php");
    exit;
}

// Obtiene datos de sesión
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
$fecha = date('d/m/Y H:i');


$resultado = $conexion->query("SELECT * FROM palabras");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Administrador</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000000;
            color: #FFD700;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #000000;
            color: #FFD700;
            padding: 1em 2em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(255, 215, 0, 0.5);
        }
        nav .user-info span {
            margin-right: 1em;
            font-weight: bold;
        }
        nav a {
            color: #000000;
            background-color: #FFD700;
            text-decoration: none;
            padding: 0.5em 1em;
            border-radius: 4px;
            font-weight: bold;
        }
        nav a:hover {
            background-color: #FFEC8B;
        }
        h2, h3 {
            text-align: center;
            color: #FFD700;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 1em;
            background: #1a1a1a;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }
        form input, form textarea {
            width: 100%;
            padding: 0.7em;
            margin-bottom: 1em;
            border: 1px solid #FFD700;
            border-radius: 4px;
            background-color: #000000;
            color: #FFD700;
        }
        form button {
            background-color: #FFD700;
            color: #000000;
            padding: 0.7em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }
        form button:hover {
            background-color: #FFEC8B;
        }
        .palabras {
            max-width: 1000px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 1em;
        }
        .palabra {
            background: #1a1a1a;
            padding: 1em;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #FFD700;
        }
        .palabra .contenido {
            display: flex;
            align-items: center;
            gap: 1em;
        }
        .palabra img {
            width: 100px;
            height: auto;
            border: 2px solid #FFD700;
            border-radius: 5px;
        }
        .palabra .info h4 {
            margin: 0 0 0.5em 0;
        }
        .palabra .info p {
            margin: 0;
        }
        .palabra .eliminar-btn {
            color: #FFD700;
            background-color: #000000;
            text-decoration: none;
            padding: 0.5em 1em;
            border-radius: 4px;
            font-weight: bold;
            border: 1px solid #FFD700;
        }
        .palabra .eliminar-btn:hover {
            background-color: #FFEC8B;
            color: #000000;
        }
    </style>
</head>
<body>

<nav>
    <div><strong>Panel del Administrador</strong></div>
    <div class="usuario-info">
        <span>Usuario: <?= htmlspecialchars($usuario) ?></span>
        <span>Rol: <?= htmlspecialchars($rol) ?></span>
        <span>Fecha: <?= $fecha ?></span>
        <a href="../includes/cerrar_sesion.php">Cerrar Sesión</a>
    </div>
</nav>


<h2>Publicar Nueva Palabra</h2>
<form action="subir.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="titulo" placeholder="Palabra" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="file" name="imagen" required>
    <button type="submit">Subir</button>
</form>

<h3>Palabras publicadas</h3>
<div class="palabras">
<?php while ($row = $resultado->fetch_assoc()): ?>
    <div class="palabra">
        <div class="contenido">
            <img src="../img/<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['titulo']) ?>">
            <div class="info">
                <h4><?= htmlspecialchars($row['titulo']) ?></h4>
                <p><?= htmlspecialchars($row['descripcion']) ?></p>
            </div>
        </div>
        <a class="eliminar-btn" href="eliminar.php?id=<?= $row['id'] ?>">Eliminar</a>
    </div>
<?php endwhile; ?>
</div>

</body>
</html>
