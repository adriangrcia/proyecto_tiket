<?php
session_start();
include '../conexion.php';

// Verificar si es administrador
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <!-- Bienvenida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">👑 Bienvenido Administrador <strong><?php echo $_SESSION['nombre']; ?></strong></h2>
        <a href="../logout.php" class="btn btn-danger">🚪 Cerrar Sesión</a>
    </div>

    <!-- Opciones -->
    <div class="row g-3">
        <div class="col-md-4">
            <a href="usuarios.php" class="btn btn-primary w-100 p-3 shadow-sm">
                👥 Ver Usuarios
            </a>
        </div>
        <div class="col-md-4">
            <a href="tickets.php" class="btn btn-success w-100 p-3 shadow-sm">
                🎫 Ver Tickets
            </a>
        </div>
        <div class="col-md-4">
            <a href="crear_tecnico.php" class="btn btn-warning w-100 p-3 shadow-sm">
                ➕ Crear Técnico
            </a>
        </div>
    </div>

</body>
</html>
