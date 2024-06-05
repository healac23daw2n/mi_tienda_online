<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Aquí podrías obtener más información del usuario si lo deseas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<div class="container">
        <header>
            <h1>Bienvenido a mi tienda online</h1>
        </header>
        <main>
            <p>Has iniciado sesión correctamente.</p>
            <div class="buttons">
                <a href="catalogo_productos.php" class="button">Mi tienda</a>
                <a href="crear_usuarios.php" class="button">Crear usuarios</a>
                <a href="logout.php" class="button">Cerrar sesión</a>
            </div>
        </main>
    </div>
</body>
</html>
