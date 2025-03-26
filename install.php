<?php
$servername = "172.21.0.2";
$username = "root"; // Cambia esto por tu usuario de MySQL
$password = "root"; // Cambia esto por tu contraseña de MySQL
$dbname = "coches_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada correctamente.<br>";
} else {
    echo "Error al crear la base de datos: " . $conn->error . "<br>";
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// Crear tabla coches
$sql = "CREATE TABLE IF NOT EXISTS coches (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    color VARCHAR(30) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabla 'coches' creada correctamente.<br>";
} else {
    echo "Error al crear la tabla: " . $conn->error . "<br>";
}

// Cerrar conexión
$conn->close();
?>