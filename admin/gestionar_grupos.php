<?php
include '../config/conexion.php';
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $usuario_id = $_POST["usuario_id"];

    $sql = "INSERT INTO grupos (nombre, usuario_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre, $usuario_id);
    $stmt->execute();
}

$profesores = $conn->query("SELECT * FROM usuarios WHERE rol = 'profesor'");
$grupos = $conn->query("SELECT * FROM grupos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestionar Grupos</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Gestionar Grupos</h2>
        <form action="" method="POST">
            <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre del Grupo" required>
            <select name="usuario_id" class="form-control mb-2">
                <?php while ($profesor = $profesores->fetch_assoc()) : ?>
                    <option value="<?= $profesor["id"] ?>"><?= $profesor["nombre"] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn btn-success">Agregar Grupo</button>
        </form>
        <h3 class="mt-4">Grupos Registrados</h3>
        <ul class="list-group">
            <?php while ($grupo = $grupos->fetch_assoc()) : ?>
                <li class="list-group-item"><?= $grupo["nombre"] ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
