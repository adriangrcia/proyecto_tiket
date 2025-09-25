<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}

$result = $conn->query("SELECT id, nombre, email, rol FROM usuarios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Usuarios Registrados</h2>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['nombre']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= ucfirst($row['rol']); ?></td>
                    <td>
                        <?php if ($row['id'] != $_SESSION['id']): // Evitar auto-eliminación ?>
                            <a href="eliminar_usuario.php?id=<?= $row['id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('⚠ ¿Seguro que quieres eliminar este usuario?');">
                               🗑 Eliminar
                            </a>
                        <?php else: ?>
                            <span class="text-muted">No disponible</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary">⬅ Volver</a>
</body>
</html>
