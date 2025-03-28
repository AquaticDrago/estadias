<?php
include '../config/conexion.php';
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_vencimiento = $_POST["fecha_vencimiento"];
    $usuario_id = $_SESSION["id"];

    $sql = "INSERT INTO actividades (titulo, descripcion, fecha_vencimiento, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $titulo, $descripcion, $fecha_vencimiento, $usuario_id);
    $stmt->execute();
}

$actividades = $conn->query("SELECT * FROM actividades WHERE usuario_id = {$_SESSION["id"]}");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Actividad</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Crear Actividad</h2>
        <form action="" method="POST">
            <input type="text" name="titulo" class="form-control mb-2" placeholder="Título" required>
            <textarea name="descripcion" class="form-control mb-2" placeholder="Descripción" required></textarea>
            <input type="date" name="fecha_vencimiento" class="form-control mb-2" required>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
        <h3 class="mt-4">Actividades Creadas</h3>
        <ul class="list-group">
            <?php while ($actividad = $actividades->fetch_assoc()) : ?>
                <li class="list-group-item"><?= $actividad["titulo"] ?> - <?= $actividad["fecha_vencimiento"] ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
