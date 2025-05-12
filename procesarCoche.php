<?php
session_start();
require_once './config/configBD.php';

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = trim($_POST['marca'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $anio = intval($_POST['anio'] ?? 0);
    $color = trim($_POST['color'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $presupuesto = floatval($_POST['presupuesto'] ?? 0);
    $kilometros = 0;  // Asumimos que es 0 por defecto (nuevo vehículo)
    $potencia = intval($_POST['potencia'] ?? 0); // Potencia en caballos
    $combustible = trim($_POST['combustible'] ?? ''); // Gasolina, Diésel, Eléctrico, Híbrido
    $imagen = $_FILES['imagen'] ?? null;

    // Validación de campos obligatorios
    if (empty($marca) || empty($modelo) || $anio === 0 || $presupuesto === 0 || empty($combustible)) {
        header("Location: adminDashboard.php?error=Faltan datos obligatorios.");
        exit();
    }

    $imagenRutaRelativa = ''; // Por defecto, vacío

    if ($imagen && $imagen['error'] === 0) {
        // Validación de tipo MIME (opcional pero recomendable)
        $tiposValidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($imagen['type'], $tiposValidos)) {
            header("Location: adminDashboard.php?error=Tipo de archivo no válido. Solo JPG, PNG o WEBP.");
            exit();
        }

        $carpeta = __DIR__ . '/images/';
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $nombreSeguro = time() . "_" . basename($imagen['name']);
        $imagenRuta = $carpeta . $nombreSeguro;

        $contador = 1;
        while (file_exists($imagenRuta)) {
            $nombreSeguro = time() . "_" . $contador . "_" . basename($imagen['name']);
            $imagenRuta = $carpeta . $nombreSeguro;
            $contador++;
        }

        if (!move_uploaded_file($imagen['tmp_name'], $imagenRuta)) {
            header("Location: adminDashboard.php?error=No se pudo guardar la imagen.");
            exit();
        }

        $imagenRutaRelativa = 'images/' . $nombreSeguro;
    }

    // Insertar los datos del vehículo en la base de datos
    $sql = "INSERT INTO vehiculos_km0 (marca, modelo, anio, color, tipo, presupuesto, kilometros, potencia_cv, combustible, imagen)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("❌ Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssissdssss", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $potencia, $combustible, $imagenRutaRelativa);

    if ($stmt->execute()) {
        header("Location: adminDashboard.php?message=Vehículo KM0 añadido con éxito");
    } else {
        header("Location: adminDashboard.php?error=Error al insertar el vehículo.");
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    header("Location: adminDashboard.php");
    exit();
}
?>
