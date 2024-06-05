CREATE DATABASE IF NOT EXISTS tienda_online;
USE tienda_online;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    rol VARCHAR(50),
    es_anonimo BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    imagen VARCHAR(255)
);

-- Añadir el rol admin al usuario con ID 1
UPDATE usuarios SET rol = 'admin' WHERE id = 1;

-- Asignar rol de gestora a Laia
UPDATE usuarios SET rol = 'gestora' WHERE nombre_usuario = 'Laia';

ALTER TABLE usuarios ADD COLUMN es_anonimo BOOLEAN DEFAULT FALSE;
