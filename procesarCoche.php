<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$anio = $_POST['anio'];
$color = $_POST['color'];
$tipo = $_POST['tipo'];
$presupuesto = $_POST['presupuesto'];
$kilometros = $_POST['kilometros'];
$imagen = $_FILES['imagen'];

// Subir la imagen si se ha cargado una
$imagenRuta = "";
if ($imagen['error'] == 0) {
    $imagenRuta = 'images/' . basename($imagen['name']);
    move_uploaded_file($imagen['tmp_name'], $imagenRuta);
}

// Validar el teléfono solo si los kilómetros son mayores a 0
$telefono = null;
if ($kilometros > 0 && isset($_POST['telefono']) && !empty($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}

// Insertar en la tabla correspondiente utilizando consultas preparadas
if ($kilometros == 0) {
    // Insertar en la tabla vehiculos_km0
    $sql = "INSERT INTO vehiculos_km0 (marca, modelo, anio, color, tipo, presupuesto, kilometros, imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssississ", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $imagenRuta);
} else {
    
    $sql = "INSERT INTO coche_usuario (marca, modelo, anio, color, tipo, presupuesto, kilometros, telefono, imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssississs", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $telefono, $imagenRuta);
}

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir al dashboard con un mensaje de éxito
    header("Location: adminDashboard.php?message=Vehículo añadido con éxito");
    exit();
} else {
    // Redirigir al dashboard con un mensaje de error
    header("Location: adminDashboard.php?error=Hubo un error al añadir el vehículo");
    exit();
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
