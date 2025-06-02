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

// Paginación
$cardsPorPagina = 6;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * $cardsPorPagina;

// Búsqueda
$busqueda = isset($_GET['busqueda']) ? $conexion->real_escape_string($_GET['busqueda']) : "";

// Contar total de resultados
$sqlTotal = "SELECT COUNT(*) AS total FROM palabras";
if (!empty($busqueda)) {
    $sqlTotal .= " WHERE titulo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
}
$totalResultado = $conexion->query($sqlTotal)->fetch_assoc();
$totalCards = $totalResultado['total'];
$totalPaginas = ceil($totalCards / $cardsPorPagina);

// Obtener datos paginados
$sql = "SELECT * FROM palabras";
if (!empty($busqueda)) {
    $sql .= " WHERE titulo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
}
$sql .= " LIMIT $inicio, $cardsPorPagina";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diccionario</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background-color: #000;
            color: #ffd700;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #111;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            border-bottom: 2px solid #ffd700;
        }
        nav div {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .usuario-info span {
            margin-right: 1rem;
            font-size: 1rem;
        }
        .usuario-info a {
            background-color: #ffd700;
            color: #000;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 5px;
        }
        h2 {
            text-align: center;
            margin-top: 2rem;
            color: #ffd700;
        }
        .contenedor-general {
            background-color: #000;
            border: 3px solid #ffd700;
            border-radius: 15px;
            margin: 1cm;
            padding: 1rem;
        }
        .busqueda-container {
            text-align: center;
            margin-bottom: 1rem;
        }
        .busqueda-container input {
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .busqueda-container button {
            padding: 0.5rem 1rem;
            background-color: #ffd700;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .contenedor-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            padding: 1rem;
        }
        .card {
            background-color: #222;
            border: 2px solid #ffd700;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .card h4 {
            margin: 0.5rem 0;
        }
        .paginacion {
            text-align: center;
            margin: 1rem 0;
        }
        .paginacion a, .paginacion span {
            color: #ffd700;
            background-color: #111;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 5px;
            text-decoration: none;
        }
        .paginacion .actual {
            background-color: #ffd700;
            color: #000;
        }
    </style>
</head>
<body>

<nav>
    <div>Panel del Cliente</div>
    <div class="usuario-info">
        <span>Usuario: <?= htmlspecialchars($usuario) ?></span>
        <span>Rol: <?= htmlspecialchars($rol) ?></span>
        <span>Fecha: <?= $fecha ?></span>
        <a href="../includes/cerrar_sesion.php">Cerrar Sesión</a>
    </div>
</nav>

<h2>Bienvenido al Diccionario</h2>

<div class="contenedor-general">
    <!-- Busqueda dentro del contenedor -->
    <div class="busqueda-container">
        <form method="GET" action="">
            <input type="text" name="busqueda" placeholder="Buscar palabra..." value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="contenedor-cards">
        <?php if ($totalCards == 0): ?>
            <p style="color:#ffd700; text-align:center; width: 100%;">No se encontraron resultados.</p>
        <?php else: ?>
            <?php while ($row = $resultado->fetch_assoc()): ?>
                <div class="card">
                    <img src="../img/<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['titulo']) ?>">
                    <h4><?= htmlspecialchars($row['titulo']) ?></h4>
                    <p><?= htmlspecialchars($row['descripcion']) ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Paginación -->
    <?php if ($totalCards > 0): ?>
    <div class="paginacion">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?= $i ?>&busqueda=<?= urlencode($busqueda) ?>" class="<?= $i == $paginaActual ? 'actual' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
