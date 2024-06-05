<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $email = $_POST['email'];
    $rol = 'cliente';

    // Validar datos
    if (empty($nombre_usuario) || empty($contrasena) || empty($email)) {
        $error = 'Por favor, completa todos los campos.';
    } else {
        $contrasena_hashed = password_hash($contrasena, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, email, rol) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nombre_usuario, $contrasena_hashed, $email, $rol])) {
            $success = 'Usuario creado exitosamente.';
        } else {
            $error = 'Hubo un problema al crear el usuario.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuarios</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Crear Nuevo Usuario</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <form action="crear_usuarios.php" method="POST">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
        
        <button type="submit">Crear Usuario</button>
    </form>
    <a href="dashboard.php">Volver al Dashboard</a>
</body>
</html>
