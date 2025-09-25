<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'cliente') {
    header("Location: index.html");
    exit();
}

// Obtener técnicos
$sql = "SELECT id, nombre FROM usuarios WHERE rol = 'tecnico'";
$result = $conn->query($sql);
$tecnicos = [];
while ($row = $result->fetch_assoc()) {
    $tecnicos[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2 class="mb-4">Crear nuevo Ticket</h2>
    <form action="guardar_ticket.php" method="POST" class="card p-4 shadow">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Asignar a Técnico</label>
            <select name="tecnico_id" class="form-select">
                <option value="">Sin Asignar</option>
                <?php foreach ($tecnicos as $tec): ?>
                    <option value="<?= $tec['id'] ?>"><?= $tec['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Crear Ticket</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
