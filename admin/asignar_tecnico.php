<?php
session_start();
include '../conexion.php';

if ($_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_id = $_POST['ticket_id'];
    $tecnico_id = $_POST['tecnico_id'];

    $sql = "UPDATE tickets SET tecnico_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $tecnico_id, $ticket_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Técnico asignado correctamente'); window.location.href='tickets.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
