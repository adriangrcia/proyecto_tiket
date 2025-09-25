<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        die("❌ Las contraseñas no coinciden.");
    }

    // Sacar el nombre desde el email (todo lo que está antes del @)
    $nombre = explode('@', $email)[0];

    // Encriptar la contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar en la tabla usuarios
    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'cliente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hash);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Usuario registrado con éxito'); window.location.href='index.php';</script>";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>



