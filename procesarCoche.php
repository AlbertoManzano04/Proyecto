<?php
session_start();
require_once './config/configBD.php'; // Asegúrate de que esta ruta sea correcta

// Activar la visualización de errores solo para depuración. ¡Desactiva esto en producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    // Si la conexión a la BD falla, redirige con un error.
    header("Location: adminDashboard.php?error=Conexión a la base de datos fallida: " . $conn->connect_error);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoge y sanea los datos del formulario POST
    $marca = trim($_POST['marca'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $anio = intval($_POST['anio'] ?? 0);
    $color = trim($_POST['color'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $presupuesto = floatval($_POST['presupuesto'] ?? 0);
    $kilometros = 0; // Asumimos 0 para vehículos KM0 (concesionario)
    $potencia = intval($_POST['potencia'] ?? 0); // Potencia en caballos
    $combustible = trim($_POST['combustible'] ?? ''); // Tipo de combustible
    $imagen = $_FILES['imagen'] ?? null; // Datos de la imagen subida

    // Validación de campos obligatorios
    if (empty($marca) || empty($modelo) || $anio === 0 || $presupuesto <= 0 || empty($combustible)) {
        header("Location: adminDashboard.php?error=Faltan datos obligatorios o son inválidos.");
        exit();
    }

    $imagenRutaRelativa = ''; // Por defecto, vacío

    // Procesamiento de la imagen si se subió una
    if ($imagen && $imagen['error'] === 0) {
        $tiposValidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($imagen['type'], $tiposValidos)) {
            header("Location: adminDashboard.php?error=Tipo de archivo de imagen no válido. Solo JPG, PNG o WEBP.");
            exit();
        }

        $carpeta = __DIR__ . '/images/'; // Carpeta donde se guardarán las imágenes
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true); // Crea la carpeta si no existe
        }

        // Genera un nombre de archivo único para evitar colisiones
        $nombreSeguro = time() . "_" . basename($imagen['name']);
        $imagenRuta = $carpeta . $nombreSeguro;

        // Si el nombre ya existe (poco probable con time()), añade un contador
        $contador = 1;
        while (file_exists($imagenRuta)) {
            $nombreSeguro = time() . "_" . $contador . "_" . basename($imagen['name']);
            $imagenRuta = $carpeta . $nombreSeguro;
            $contador++;
        }

        // Mueve la imagen subida desde su ubicación temporal al destino final
        if (!move_uploaded_file($imagen['tmp_name'], $imagenRuta)) {
            header("Location: adminDashboard.php?error=No se pudo guardar la imagen.");
            exit();
        }

        $imagenRutaRelativa = 'images/' . $nombreSeguro; // Ruta relativa para guardar en la BD
    }

    // Insertar los datos del vehículo en la base de datos local (vehiculos_km0)
    // NOTA: 'wp_post_id' NO se inserta aquí. Se actualizará en subir_coche_wp.php.
    $sql = "INSERT INTO vehiculos_km0 (marca, modelo, anio, color, tipo, presupuesto, kilometros, potencia_cv, combustible, imagen)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        header("Location: adminDashboard.php?error=Error al preparar la consulta SQL: " . $conn->error);
        exit();
    }

    // Vincula los parámetros y ejecuta la consulta
    $stmt->bind_param("ssissdssss", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $potencia, $combustible, $imagenRutaRelativa);

    if ($stmt->execute()) {
        // Obtener el ID del vehículo recién insertado en tu base de datos local
        $vehiculo_local_id = $stmt->insert_id;
        
        // Preparamos los datos para WooCommerce
        $wp_coche_nombre = $marca . ' ' . $modelo . ' ' . $anio; // Nombre completo para WordPress
        $wp_coche_descripcion = 'Color: ' . $color . '<br>' .
                                'Combustible: ' . $combustible . '<br>' .
                                'Potencia: ' . $potencia . ' CV<br>' .
                                'Tipo: ' . $tipo . '<br>' .
                                'Kilómetros: ' . $kilometros . ' km';
        $wp_coche_precio = $presupuesto;

        $stmt->close();
        $conn->close(); // Cierra la conexión a la base de datos antes de la redirección

        // Redirige a subir_coche_wp.php, pasando el ID local y todos los datos necesarios
        header("Location: /php/Proyecto/subir_coche_wp.php?" .
               "vehiculo_id=" . urlencode($vehiculo_local_id) . "&" . // ¡ESENCIAL! El ID de tu DB local
               "nombre=" . urlencode($wp_coche_nombre) . "&" .
               "descripcion=" . urlencode($wp_coche_descripcion) . "&" .
               "precio=" . urlencode($wp_coche_precio) . "&" .
               "imagen_url=" . urlencode($imagenRutaRelativa));
        exit(); // Crucial para detener el script después de la redirección
    } else {
        // Si hay un error al insertar en la BD, redirige con un mensaje de error.
        header("Location: adminDashboard.php?error=Error al insertar el vehículo en la base de datos: " . $stmt->error);
        exit();
    }

} else {
    // Si la solicitud no es POST (por ejemplo, alguien intenta acceder directamente), redirige al dashboard.
    header("Location: adminDashboard.php");
    exit();
}
?>