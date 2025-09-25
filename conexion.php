<?php
$host = "localhost";
$user = "root";  // tu usuario de MySQL
$pass = "";      // tu contraseña de MySQL
$db   = "proyecto_n_tecnologias"; // tu base de datos

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}
?>
