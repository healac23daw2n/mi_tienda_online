<?php
session_start();
require 'db.php';

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <h2>Productos</h2>
    <ul>
        <?php foreach ($productos as $producto): ?>
            <li>
                <h3><?= $producto['nombre'] ?></h3>
                <p><?= $producto['descripcion'] ?></p>
                <p>Precio: <?= $producto['precio'] ?> €</p>
                <?php if ($producto['imagen']): ?>
                    <img src="images/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>" width="100">
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Volver al dash</a>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
