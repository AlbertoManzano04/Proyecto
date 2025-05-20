<?php
require_once '../config/configBD.php';

// Conectar con la base de datos 
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, "", DB_PORT);

// Verificamos la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Creamos la base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada o ya existente.<br>";
} else {
    die("Error al crear la base de datos: " . $conn->error);
}

// Seleccionamos la base de datos
$conn->select_db(DB_NAME);

// Crear tabla usuarios con roles
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario'
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla usuarios creada con éxito.<br>";
} else {
    echo "Error al crear la tabla usuarios: " . $conn->error . "<br>";
}

// Insertar usuario administrador por defecto
$admin_email = 'admin@concesionario.com';
$admin_password = password_hash('admin123', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO usuarios (nombre, email, contraseña, rol) VALUES ('Administrador', '$admin_email', '$admin_password', 'admin')";
if ($conn->query($sql) === TRUE) {
    echo "Usuario administrador creado con éxito.<br>";
} else {
    echo "Error al crear el usuario administrador: " . $conn->error . "<br>";
}
//crear tabla notas
$sql="CREATE TABLE IF NOT EXISTS notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenido TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla notas creada con éxito.<br>";
} else {
    echo "Error al crear la tabla notas: " . $conn->error . "<br>";
}
// Crear tabla Contacto con relación a usuarios
$sql = "CREATE TABLE IF NOT EXISTS Contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mensaje TEXT NOT NULL,
    usuario_id INT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla Contacto creada con éxito.<br>";
} else {
    echo "Error al crear la tabla Contacto: " . $conn->error . "<br>";
}

// Crear tabla vehiculos_km0
$sql = "CREATE TABLE IF NOT EXISTS vehiculos_km0 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    anio INT,
    color VARCHAR(30),
    tipo VARCHAR(30),
    presupuesto DECIMAL(10,2),
    kilometros INT,
    combustible ENUM('diesel', 'gasolina', 'electrico', 'hibrido'),
    potencia_cv INT,
    imagen VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla vehiculos_km0 creada con éxito.<br>";
} else {
    echo "Error al crear la tabla vehiculos_km0: " . $conn->error . "<br>";
}

// Crear tabla coche_usuario con relación a usuarios
$sql = "CREATE TABLE IF NOT EXISTS coche_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    anio INT,
    color VARCHAR(30),
    tipo VARCHAR(30),
    presupuesto DECIMAL(10,2),
    kilometros INT,
    combustible ENUM('diesel', 'gasolina'),
    potencia_cv INT,
    imagen VARCHAR(255),
    telefono VARCHAR(15) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla coche_usuario creada con éxito.<br>";
} else {
    echo "Error al crear la tabla coche_usuario: " . $conn->error . "<br>";
}

// Crear tabla enviarCV
$sql = "CREATE TABLE IF NOT EXISTS enviarCV (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    curriculum LONGBLOB NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla enviarCV creada con éxito.<br>";
} else {
    echo "Error al crear la tabla enviarCV: " . $conn->error . "<br>";
}
$sql= "CREATE TABLE IF NOT EXISTS usuarios_favoritos (
    usuario_id INT NOT NULL,
    vehiculo_id INT NOT NULL,
    PRIMARY KEY (usuario_id, vehiculo_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (vehiculo_id) REFERENCES vehiculos_km0(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabla usuarios_favoritos creada con éxito.<br>";
} else {
    echo "Error al crear la tabla usuarios_favoritos: " . $conn->error . "<br>";
}

// Cerrar conexión
$conn->close();
?>
