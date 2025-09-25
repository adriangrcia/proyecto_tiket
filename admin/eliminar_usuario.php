<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $usuario_id = intval($_GET['id']);

    // Evitar que el admin se elimine a sí mismo
    if ($usuario_id == $_SESSION['id']) {
        echo "<script>alert('❌ No puedes eliminar tu propio usuario.'); window.location.href='usuarios.php';</script>";
        exit();
    }

    // Eliminar usuario
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Usuario eliminado correctamente.'); window.location.href='usuarios.php';</script>";
    } else {
        echo "<script>alert('❌ Error al eliminar usuario: " . $stmt->error . "'); window.location.href='usuarios.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

