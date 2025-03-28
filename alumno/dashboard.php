<?php
include '../config/conexion.php';
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "alumno") {
    header("Location: ../login.php");
    exit();
}

// Obtener el grupo del alumno
$grupo = $conn->query("SELECT grupo_id FROM alumnos WHERE id = {$_SESSION['id']}")->fetch_assoc();
$grupo_id = $grupo["grupo_id"];

// Obtener actividades del profesor asignado al grupo del alumno
$actividades = $conn->query("
    SELECT actividades.titulo, actividades.descripcion, actividades.fecha_vencimiento 
    FROM actividades 
    INNER JOIN grupos ON actividades.usuario_id = grupos.usuario_id 
    WHERE grupos.id = $grupo_id
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actividades Asignadas</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Actividades Asignadas</h2>
        <ul class="list-group">
            <?php while ($actividad = $actividades->fetch_assoc()) : ?>
                <li class="list-group-item">
                    <strong><?= $actividad["titulo"] ?></strong><br>
                    <?= $actividad["descripcion"] ?><br>
                    <small>Fecha de vencimiento: <?= $actividad["fecha_vencimiento"] ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
