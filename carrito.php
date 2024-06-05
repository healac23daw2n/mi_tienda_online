<?php
session_start();
require 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Manejar la eliminación de productos del carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product_id'])) {
    $remove_product_id = $_POST['remove_product_id'];
    foreach ($_SESSION['cart'] as $key => $producto) {
        if ($producto['id'] == $remove_product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);  // Reindexar el array
    header('Location: carrito.php');
    exit();
}

// Obtener los productos comprados desde la sesión del carrito
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Total del carrito
$total = 0;
foreach ($cart as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Carrito de Compras</h1>
    <?php if (empty($cart)): ?>
        <p>No has comprado ningún producto aún.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo number_format($producto['precio'], 2); ?> €</td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?> €</td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="remove_product_id" value="<?php echo $producto['id']; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Total: <?php echo number_format($total, 2); ?> €</h2>
    <?php endif; ?>
    <a href="catalogo_productos.php">Volver al Catálogo</a>
</body>
</html>
