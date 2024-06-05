<?php
require 'db.php';


$nombre_usuario = 'maka';
$contrasena = password_hash('cliente123', PASSWORD_BCRYPT);
$email = 'cliente@example.com';
$rol = 'cliente';


$stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, email, rol) VALUES (?, ?, ?, ?)");
$stmt->execute([$nombre_usuario, $contrasena, $email, $rol]);

echo "El nuevo usuario cliente ha sido creado correctamente.";
?>
