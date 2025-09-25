<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT t.id, t.titulo, t.descripcion, t.estado, t.fecha_creacion, 
               c.nombre AS cliente, tec.nombre AS tecnico
        FROM tickets t
        JOIN usuarios c ON t.usuario_id = c.id
        LEFT JOIN usuarios tec ON t.tecnico_id = tec.id";
$result = $conn->query($sql);

$tecnicos = $conn->query("SELECT id, nombre FROM usuarios WHERE rol='tecnico'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php if ($_SESSION['rol'] == 'administrador'): ?>
        <a href="crear_ticket.php" class="btn btn-success mb-3">Crear nuevo Ticket</a>
    <?php endif; ?>

    <h2>Todos los Tickets</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th><th>Título</th><th>Descripción</th>
                <th>Estado</th><th>Cliente</th><th>Técnico</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td><?php echo $row['cliente']; ?></td>
                    <td><?php echo $row['tecnico'] ?? '❌ Sin asignar'; ?></td>
                    <td>
                        <!-- Asignar Técnico -->
                        <?php if (!$row['tecnico']): ?>
                            <form method="POST" action="asignar_tecnico.php" class="d-flex gap-2 mb-2">
                                <input type="hidden" name="ticket_id" value="<?php echo $row['id']; ?>">
                                <select name="tecnico_id" class="form-select form-select-sm" required>
                                    <option value="">-- Seleccionar Técnico --</option>
                                    <?php
                                    $tecnicos->data_seek(0);
                                    while ($tec = $tecnicos->fetch_assoc()) {
                                        echo "<option value='".$tec['id']."'>".$tec['nombre']."</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm">Asignar</button>
                            </form>
                        <?php else: ?>
                            ✅ Asignado
                        <?php endif; ?>

                        <!-- Cambiar Estado -->
                        <form method="POST" action="cambiar_estado.php" class="d-flex gap-2">
                                <input type="hidden" name="ticket_id" value="<?= $row['id']; ?>">
                                <select name="estado" class="form-select form-select-sm">
                                    <option value="Pendiente" <?= $row['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="Abierto" <?= $row['estado'] == 'Abierto' ? 'selected' : '' ?>>Abierto</option>
                                    <option value="Atendido" <?= $row['estado'] == 'Atendido' ? 'selected' : '' ?>>Atendido</option>
                                    <option value="Cerrado" <?= $row['estado'] == 'Cerrado' ? 'selected' : '' ?>>Cerrado</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">⬅ Volver</a>
</body>
</html>
