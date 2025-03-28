<?php
require_once '../config/configBD.php';

// Crear conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Seleccionar la base de datos
$conn->select_db(DB_NAME);

// Definir la estructura de las tablas
$tables = [
    "coches" => "CREATE TABLE IF NOT EXISTS coches (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        marca VARCHAR(50) NOT NULL,
        color VARCHAR(30) NOT NULL,
        tipo VARCHAR(50) NOT NULL,
        precio DECIMAL(10,2) NOT NULL
    )",
    "usuarios" => "CREATE TABLE IF NOT EXISTS usuarios (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

// Crear tablas
foreach ($tables as $name => $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Tabla '$name' creada correctamente.<br>";
    } else {
        echo "Error al crear la tabla '$name': " . $conn->error . "<br>";
    }
}

// Cerrar conexión
$conn->close();
?>

