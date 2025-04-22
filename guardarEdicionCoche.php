<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar que llegue el ID y la tabla
if (!isset($_POST['id'], $_POST['tabla'])) {
    die("Datos incompletos.");
}

$id = $_POST['id'];
$tabla = $_POST['tabla'];

// Obtener los datos del formulario
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$anio = $_POST['anio'];
$color = $_POST['color'];
$tipo = $_POST['tipo'];
$presupuesto = $_POST['presupuesto'];
$kilometros = $_POST['kilometros'];

// Imagen (opcional)
$imagen = null;
if (!empty($_FILES['imagen']['name'])) {
    $carpetaDestino = './images/';
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }
    $nombreArchivo = basename($_FILES["imagen"]["name"]);
    $rutaArchivo = $carpetaDestino . $nombreArchivo;

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
        $imagen = $rutaArchivo;
    }
}

// Crear la query
if ($imagen) {
    $stmt = $conn->prepare("UPDATE $tabla SET marca=?, modelo=?, anio=?, color=?, tipo=?, presupuesto=?, kilometros=?, imagen=? WHERE id=?");
    $stmt->bind_param("ssisssdsi", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $imagen, $id);
} else {
    $stmt = $conn->prepare("UPDATE $tabla SET marca=?, modelo=?, anio=?, color=?, tipo=?, presupuesto=?, kilometros=? WHERE id=?");
    $stmt->bind_param("ssisssdi", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $id);
}

if ($stmt->execute()) {
    header("Location: adminDashboard.php?msg=editado");
    exit;
} else {
    echo "Error al guardar: " . $stmt->error;
}
?>
