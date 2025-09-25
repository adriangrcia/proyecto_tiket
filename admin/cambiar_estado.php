<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['id']) || ($_SESSION['rol'] !== 'administrador' && $_SESSION['rol'] !== 'tecnico')) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $estado = $_POST['estado'];

    $sql = "UPDATE tickets SET estado=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estado, $ticket_id);

    if ($stmt->execute()) {
        header("Location: tickets.php");
        exit();
    } else {
        echo "Error al actualizar el estado: " . $conn->error;
    }
}
?>
