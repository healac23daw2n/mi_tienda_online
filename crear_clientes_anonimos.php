<?php
session_start();
require 'db.php';

// Verificar si el usuario está conectado y es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientes = [
        ['id' => 501, 'nombre_usuario' => 'cla1'],
        ['id' => 502, 'nombre_usuario' => 'cla2'],
        ['id' => 503, 'nombre_usuario' => 'cla3'],
        ['id' => 504, 'nombre_usuario' => 'cla4'],
        ['id' => 505, 'nombre_usuario' => 'cla5'],
    ];

    try {
        $pdo->beginTransaction();

        foreach ($clientes as $cliente) {
            $stmt = $pdo->prepare("INSERT INTO usuarios (id, nombre_usuario, contrasena, email, rol, es_anonimo) VALUES (?, ?, '', '', 'cliente', TRUE)");
            $stmt->execute([$cliente['id'], $cliente['nombre_usuario']]);
        }

        $pdo->commit();
        $success = 'Clientes anónimos creados exitosamente.';
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = 'Hubo un problema al crear los clientes anónimos: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Creación de Clientes Anónimos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Creación de Clientes Anónimos</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <form action="crear_clientes_anonimos.php" method="POST">
        <button type="submit">Crear Clientes Anónimos</button>
    </form>
    <a href="dashboard.php">Volver al Dashboard</a>
</body>
</html>
