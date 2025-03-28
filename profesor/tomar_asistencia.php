<?php
include '../config/conexion.php';
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../login.php");
    exit();
}

// Obtener actividades creadas por el profesor
$actividades = $conn->query("SELECT * FROM actividades WHERE usuario_id = {$_SESSION['id']}");

// Procesar asistencia
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actividad_id = $_POST["actividad_id"];
    $fecha = date("Y-m-d");

    foreach ($_POST["asistencia"] as $alumno_id => $estado) {
        $presente = $estado == "presente" ? 1 : 0;
        $sql = "INSERT INTO asistencias (actividad_id, alumno_id, presente, fecha) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $actividad_id, $alumno_id, $presente, $fecha);
        $stmt->execute();
    }

    echo "<script>alert('Asistencia guardada correctamente');</script>";
}

// Obtener alumnos del grupo del profesor
$grupo = $conn->query("SELECT id FROM grupos WHERE usuario_id = {$_SESSION['id']}")->fetch_assoc();
$alumnos = $conn->query("SELECT * FROM alumnos WHERE grupo_id = {$grupo['id']}");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Tomar Asistencia</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Tomar Asistencia</h2>
        <form action="" method="POST">
            <label>Selecciona Actividad:</label>
            <select name="actividad_id" class="form-control mb-2" required>
                <?php while ($actividad = $actividades->fetch_assoc()) : ?>
                    <option value="<?= $actividad["id"] ?>"><?= $actividad["titulo"] ?></option>
                <?php endwhile; ?>
            </select>
            <h3>Lista de Alumnos</h3>
            <?php while ($alumno = $alumnos->fetch_assoc()) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="asistencia[<?= $alumno["id"] ?>]" value="presente" required> Presente
                    <input class="form-check-input" type="radio" name="asistencia[<?= $alumno["id"] ?>]" value="ausente"> Ausente
                    <label class="form-check-label"><?= $alumno["nombre"] ?></label>
                </div>
            <?php endwhile; ?>
            <button type="submit" class="btn btn-primary mt-3">Guardar Asistencia</button>
        </form>
    </div>
</body>
</html>
