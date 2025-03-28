<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$rol = $_SESSION["rol"];
if ($rol == "admin") {
    header("Location: admin/dashboard.php");
} elseif ($rol == "profesor") {
    header("Location: profesor/dashboard.php");
} else {
    header("Location: alumno/dashboard.php");
}
?>
