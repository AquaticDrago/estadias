<?php
include 'config/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
    $rol = $_POST["rol"];

    $sql = "INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $rol);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado exitosamente'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Registro de Usuario</h2>
        <form action="register.php" method="POST">
            <input type="text" name="nombre" class="form-control mb-3" placeholder="Nombre" required>
            <input type="email" name="correo" class="form-control mb-3" placeholder="Correo" required>
            <input type="password" name="contrasena" class="form-control mb-3" placeholder="Contraseña" required>
            <select name="rol" class="form-control mb-3">
                <option value="profesor">Profesor</option>
                <option value="alumno">Alumno</option>
            </select>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>
</body>
</html>
