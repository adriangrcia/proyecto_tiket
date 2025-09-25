<?php
session_start();
include '../conexion.php';

// Verificar si es técnico
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'tecnico') {
    header("Location: ../index.php");
    exit();
}

$ticket_id = $_GET['id'] ?? null;
$tecnico_id = $_SESSION['id'];

if (!$ticket_id) {
    header("Location: index.php");
    exit();
}

// Consultar ticket
$sql = "SELECT * FROM tickets WHERE id = ? AND tecnico_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ticket_id, $tecnico_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();

if (!$ticket) {
    echo "<script>alert('❌ Ticket no encontrado o no asignado a ti'); window.location.href='index.php';</script>";
    exit();
}

// Actualizar estado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_estado = $_POST['estado'];

    $update = "UPDATE tickets SET estado = ? WHERE id = ? AND tecnico_id = ?";
    $stmt2 = $conn->prepare($update);
    $stmt2->bind_param("sii", $nuevo_estado, $ticket_id, $tecnico_id);

    if ($stmt2->execute()) {
        echo "<script>alert('✅ Estado actualizado correctamente'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt2->error;
    }
    $stmt2->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>✏ Cambiar Estado del Ticket</h3>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Título:</label>
            <input type="text" class="form-control" value="<?php echo $ticket['titulo']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea class="form-control" rows="3" disabled><?php echo $ticket['descripcion']; ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select name="estado" class="form-select" required>
                <option value="Pendiente" <?php if($ticket['estado']=="Pendiente") echo "selected"; ?>>Pendiente</option>
                <option value="Abierto" <?php if($ticket['estado']=="Abierto") echo "selected"; ?>>Abierto</option>
                <option value="Atendido" <?php if($ticket['estado']=="Atendido") echo "selected"; ?>>Atendido</option>
                <option value="Cerrado" <?php if($ticket['estado']=="Cerrado") echo "selected"; ?>>Cerrado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success" >Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
