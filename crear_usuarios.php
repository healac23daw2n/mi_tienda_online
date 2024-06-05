CREACIÓN DE USUARIOS ADMIN 

<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, email) VALUES (?, ?, ?)");
    $stmt->execute([$nombre_usuario, $contrasena, $email]);

    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>CREACIÓN DE USUARIOS ADMIN </h2>
    <form action="register.php" method="POST">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <button type="submit">Registrar</button>
    </form>
    <a href="dashboard.php">Volver al dash</a>
</body>
</html>
