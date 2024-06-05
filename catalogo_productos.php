<?php
session_start();
require 'db.php';


if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}


$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

    // Buscar el producto en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch();

    if ($producto) {
        $item = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => $cantidad
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Verificar si el producto ya está en el carrito
        $found = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $item['id']) {
                $cart_item['cantidad'] += $item['cantidad'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item;
        }
    }
    header('Location: catalogo_productos.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Catálogo de Productos</h1>
    <ul>
        <?php foreach ($productos as $producto): ?>
            <li>
                <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                <p>Precio: <?= htmlspecialchars($producto['precio']) ?> €</p>
                <form method="post">
                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                    <label for="cantidad_<?= $producto['id'] ?>">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad_<?= $producto['id'] ?>" value="1" min="1">
                    <button type="submit">Añadir al Carrito</button> 

                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="carrito.php">Ver Carrito</a>
    <a href="logout.php" class="button">Cerrar sesión</a>
</body>
</html>
