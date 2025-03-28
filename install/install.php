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
$sql = "CREATE TABLE IF NOT EXISTS Coche_km0 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    color VARCHAR(30) NOT NULL,
    tipo VARCHAR(50) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla Coche_km0 creada con éxito.<br>";
} else {
    echo "Error al crear la tabla Coche_km0: " . $conn->error . "<br>";
}

// Crear tabla Coche_Usuario
$sql = "CREATE TABLE IF NOT EXISTS Coche_Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    color VARCHAR(30) NOT NULL,
    kilometros INT NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla Coche_Usuario creada con éxito.<br>";
} else {
    echo "Error al crear la tabla Coche_Usuario: " . $conn->error . "<br>";
}

// Cerrar conexión
$conn->close();
?>
