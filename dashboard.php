<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.html");
    exit();
}

// Si es cliente, ve solo sus tickets
if ($_SESSION['rol'] == 'cliente') {
    $sql = "SELECT t.id, t.titulo, t.descripcion, t.estado, t.fecha_creacion, 
                   u.nombre AS tecnico 
            FROM tickets t 
            LEFT JOIN usuarios u ON t.tecnico_id = u.id
            WHERE t.usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Otros roles podrían ver todo
    $result = $conn->query("SELECT * FROM tickets");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2 class="mb-4">Bienvenido, <?= $_SESSION['nombre'] ?> (<?= $_SESSION['rol'] ?>)</h2>

    <?php if ($_SESSION['rol'] == 'cliente'): ?>
        <a href="crear_ticket.php" class="btn btn-success mb-3">Crear nuevo Ticket</a>
    <?php endif; ?>

    <table class="table table-striped table-bordered shadow">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Técnico Asignado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['titulo'] ?></td>
                    <td><?= $row['descripcion'] ?></td>
                    <td><?= $row['estado'] ?></td>
                    <td><?= $row['tecnico'] ?? 'Sin asignar' ?></td>
                    <td><?= $row['fecha_creacion'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="mb-3">
        <a href="logout.php" class="btn btn-danger">🚪 Cerrar Sesión</a>
    </div>


</body>
</html>
