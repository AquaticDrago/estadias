<?php
include '../config/conexion.php';
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

$result = $conn->query("SELECT * FROM usuarios WHERE rol != 'admin'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Panel de Administrador</h2>
        <a href="gestionar_usuarios.php" class="btn btn-primary">Gestionar Usuarios</a>
        <a href="gestionar_grupos.php" class="btn btn-secondary">Gestionar Grupos</a>
        <a href="../logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</body>
</html>
