<?php
session_start();
include 'conexion.php';

// 🚫 Solo procesar si viene desde POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            if ($usuario['rol'] == 'cliente') {
                header("Location: dashboard.php");
            } elseif ($usuario['rol'] == 'administrador') {
                header("Location: admin/");
            } elseif ($usuario['rol'] == 'tecnico') {
                header("Location: tecnico/");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "<script>alert('❌ Contraseña incorrecta'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('❌ Usuario no encontrado'); window.location.href='index.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Si alguien entra directo a login.php sin POST, volver al index
    header("Location: index.php");
    exit();
}
?>
