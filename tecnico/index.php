<?php
session_start();
include '../conexion.php';

// Verificar si es técnico
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'tecnico') {
    header("Location: ../index.php");
    exit();
}

$tecnico_id = $_SESSION['id'];

// Consultar tickets asignados al técnico
$sql = "SELECT t.id, t.titulo, t.descripcion, t.estado, t.fecha_creacion, u.nombre AS cliente 
        FROM tickets t
        JOIN usuarios u ON t.usuario_id = u.id
        WHERE t.tecnico_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tecnico_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">👨‍🔧 Bienvenido Técnico <?php echo $_SESSION['nombre']; ?></h2>

    <div class="mb-3">
        <a href="../logout.php" class="btn btn-danger">🚪 Cerrar Sesión</a>
    </div>

    <h4>📋 Tickets asignados a ti</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php echo $row['cliente']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td><?php echo $row['fecha_creacion']; ?></td>
                    <td>
                        <a href="editar_ticket.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">✏ Cambiar Estado</a>
                        <!-- 🚫 Sin eliminar (solo cliente puede hacerlo) -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
