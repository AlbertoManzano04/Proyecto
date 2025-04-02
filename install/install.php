<?php
require_once '../config/configBD.php';

// Conectar con MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, "", DB_PORT);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada o ya existente.<br>";
} else {
    die("Error al crear la base de datos: " . $conn->error);
}

// Seleccionar la base de datos
$conn->select_db(DB_NAME);

// Crear tabla Usuario
$sql = "CREATE TABLE IF NOT EXISTS Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mensaje TEXT NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla Usuario creada con éxito.<br>";
} else {
    echo "Error al crear la tabla Usuario: " . $conn->error . "<br>";
}

// Crear tabla Coche_km0
$sql = "CREATE TABLE IF NOT EXISTS vehiculos_km0 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    anio INT,
    color VARCHAR(30),
    tipo VARCHAR(30),
    presupuesto DECIMAL(10,2),
    kilometros INT,
    imagen VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla vehiculos_km0 creada con éxito.<br>";
} else {
    echo "Error al crear la tabla vehiculos_km0: " . $conn->error . "<br>";
}

// Crear tabla Coche_Usuario (con teléfono)
$sql = "CREATE TABLE IF NOT EXISTS coche_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    anio INT,
    color VARCHAR(30),
    tipo VARCHAR(30),
    presupuesto DECIMAL(10,2),
    kilometros INT,
    imagen VARCHAR(255),
    telefono VARCHAR(15) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla coche_usuario creada con éxito.<br>";
} else {
    echo "Error al crear la tabla coche_usuario: " . $conn->error . "<br>";
}

// Cerrar conexión
$conn->close();
?>

