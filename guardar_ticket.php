<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'cliente') {
    header("Location: index.html");
    exit();
}

$usuario_id = $_SESSION['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$tecnico_id = !empty($_POST['tecnico_id']) ? $_POST['tecnico_id'] : NULL;

$sql = "INSERT INTO tickets (usuario_id, titulo, descripcion, estado, tecnico_id) 
        VALUES (?, ?, ?, 'Pendiente', ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issi", $usuario_id, $titulo, $descripcion, $tecnico_id);
$stmt->execute();

header("Location: dashboard.php");
exit();
?>
