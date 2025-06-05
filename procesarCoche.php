<?php
session_start();
require_once './config/configBD.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: adminDashboard.php");
    exit();
}

// Recoger y limpiar datos
$marca = trim($_POST['marca'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$anio = intval($_POST['anio'] ?? 0);
$color = trim($_POST['color'] ?? '');
$tipo = trim($_POST['tipo'] ?? '');
$presupuesto = floatval($_POST['presupuesto'] ?? 0);
$kilometros = intval($_POST['kilometros'] ?? 0);
$potencia = intval($_POST['potencia_cv'] ?? 0);
$combustible = trim($_POST['combustible'] ?? '');
$imagenRutaRelativa = '';

// Validar campos obligatorios
if (empty($marca) || empty($modelo) || $anio === 0 || $presupuesto <= 0 || empty($combustible)) {
    header("Location: adminDashboard.php?error=Faltan datos obligatorios o inválidos.");
    exit();
}

// Procesar imagen (opcional)
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0 && !empty($_FILES['imagen']['tmp_name'])) {
    $imagen = $_FILES['imagen'];
    $tiposValidos = ['image/jpeg', 'image/png', 'image/webp', 'image/avif'];

    if (!in_array($imagen['type'], $tiposValidos)) {
        header("Location: adminDashboard.php?error=Tipo de archivo no válido. Solo JPG, PNG, WEBP, AVIF.");
        exit();
    }

    // Carpeta 'images/' al mismo nivel que este archivo
    $carpeta = __DIR__ . '/images/';

    if (!is_dir($carpeta)) {
        if (!mkdir($carpeta, 0777, true)) {
            header("Location: adminDashboard.php?error=No se pudo crear la carpeta de imágenes en $carpeta");
            exit();
        }
    } elseif (!is_writable($carpeta)) {
        header("Location: adminDashboard.php?error=La carpeta de imágenes no tiene permisos de escritura ($carpeta).");
        exit();
    }

    // Nombre original sin cambiar nada
    $nombreArchivo = basename($imagen['name']);

    // Ruta completa donde se guardará
    $rutaArchivo = $carpeta . $nombreArchivo;

    // Ojo, si ya existe un archivo con ese nombre lo sobrescribirá
    if (!move_uploaded_file($imagen['tmp_name'], $rutaArchivo)) {
        header("Location: adminDashboard.php?error=No se pudo guardar la imagen en $rutaArchivo.");
        exit();
    }

    $imagenRutaRelativa = 'images/' . $nombreArchivo;
}

// Decidir tabla según km
if ($kilometros === 0) {
    $tabla = 'vehiculos_km0';
} else {
    $tabla = 'coche_usuario';
}

// Si es coche_usuario, necesitas usuario_id
if ($tabla === 'coche_usuario') {
    if (isset($_SESSION['usuario_id'])) {
        $usuario_id = $_SESSION['usuario_id'];
    } else {
        header("Location: adminDashboard.php?error=Usuario no autenticado.");
        exit();
    }
}

// Preparar SQL según tabla
if ($tabla === 'vehiculos_km0') {
    $sql = "INSERT INTO vehiculos_km0 (marca, modelo, anio, color, tipo, presupuesto, kilometros, potencia_cv, combustible, imagen)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissdisss",
        $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $potencia, $combustible, $imagenRutaRelativa);
} else {
    $sql = "INSERT INTO coche_usuario (marca, modelo, anio, color, tipo, presupuesto, kilometros, potencia_cv, combustible, imagen, usuario_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissdisssi",
        $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $potencia, $combustible, $imagenRutaRelativa, $usuario_id);
}

if (!$stmt) {
    header("Location: adminDashboard.php?error=Error en la consulta: " . $conn->error);
    exit();
}

if ($stmt->execute()) {
    $vehiculo_local_id = $stmt->insert_id;

    // Preparar datos para WordPress
    $wp_coche_nombre = $marca . ' ' . $modelo . ' ' . $anio;
    $wp_coche_descripcion = "Color: $color<br>Combustible: $combustible<br>Potencia: $potencia CV<br>Tipo: $tipo<br>Kilómetros: $kilometros km";
    $wp_coche_precio = $presupuesto;

    $stmt->close();
    $conn->close();

    header("Location: subir_coche_wp.php?" .
        "vehiculo_id=" . urlencode($vehiculo_local_id) . "&" .
        "nombre=" . urlencode($wp_coche_nombre) . "&" .
        "descripcion=" . urlencode($wp_coche_descripcion) . "&" .
        "precio=" . urlencode($wp_coche_precio) . "&" .
        "imagen_url=" . urlencode($imagenRutaRelativa));
    exit();
} else {
    header("Location: adminDashboard.php?error=Error al insertar vehículo: " . $stmt->error);
    exit();
}
?>





