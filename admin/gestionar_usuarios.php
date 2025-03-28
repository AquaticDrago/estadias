<?php
include '../config/conexion.php';
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
    $rol = $_POST["rol"];

    $sql = "INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $rol);
    $stmt->execute();
}

$usuarios = $conn->query("SELECT * FROM usuarios WHERE rol != 'admin'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Gestionar Usuarios</h2>
        <form action="" method="POST">
            <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
            <input type="email" name="correo" class="form-control mb-2" placeholder="Correo" required>
            <input type="password" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required>
            <select name="rol" class="form-control mb-2">
                <option value="profesor">Profesor</option>
                <option value="alumno">Alumno</option>
            </select>
            <button type="submit" class="btn btn-success">Agregar Usuario</button>
        </form>
        <h3 class="mt-4">Usuarios Registrados</h3>
        <ul class="list-group">
            <?php while ($usuario = $usuarios->fetch_assoc()) : ?>
                <li class="list-group-item"><?= $usuario["nombre"] ?> - <?= $usuario["rol"] ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
