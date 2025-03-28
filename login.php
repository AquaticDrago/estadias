<?php
include 'config/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($contrasena, $usuario["contrasena"])) {
            $_SESSION["id"] = $usuario["id"];
            $_SESSION["rol"] = $usuario["rol"];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('Correo no registrado');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <input type="email" name="correo" class="form-control mb-3" placeholder="Correo" required>
            <input type="password" name="contrasena" class="form-control mb-3" placeholder="Contraseña" required>
            <button type="submit" class="btn btn-success">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
