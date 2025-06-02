<?php
include("../includes/conexion.php");
$id = $_GET['id'];
$sql = "DELETE FROM palabras WHERE id=$id";
$conexion->query($sql);
header("Location: dashboard_admin.php");
?>