<?php
session_start();
require_once './config/configBD.php';

// Incluye WordPress para acceder a las funciones de WooCommerce
require_once __DIR__ . '/tienda/wp-load.php'; // Ajusta la ruta a tu proyecto

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
$combustible = $_POST['combustible'];
$potencia_cv = $_POST['potencia_cv'];

// Obtener imagen actual desde la base de datos
$stmtImagen = $conn->prepare("SELECT imagen, wp_post_id FROM $tabla WHERE id = ?");
$stmtImagen->bind_param("i", $id);
$stmtImagen->execute();
$resultImagen = $stmtImagen->get_result();
$vehiculo = $resultImagen->fetch_assoc();
$imagen = $vehiculo['imagen']; // Valor actual por defecto
$wp_post_id = isset($vehiculo['wp_post_id']) ? $vehiculo['wp_post_id'] : null;
$stmtImagen->close();

// Imagen (opcional - si se sube una nueva)
if (!empty($_FILES['imagen']['name'])) {
    $carpetaDestino = 'images/';
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    // Obtener el nombre original del archivo y limpiarlo
    $nombreOriginal = basename($_FILES["imagen"]["name"]);
    $nombreLimpio = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $nombreOriginal);

    // Comprobar si el archivo ya existe y renombrarlo
    $rutaArchivo = $carpetaDestino . $nombreLimpio;
    $contador = 1;
    while (file_exists($rutaArchivo)) {
        $nombreSinExtension = pathinfo($nombreLimpio, PATHINFO_FILENAME);
        $extension = pathinfo($nombreLimpio, PATHINFO_EXTENSION);
        $rutaArchivo = $carpetaDestino . $nombreSinExtension . "_" . $contador . "." . $extension;
        $contador++;
    }

    // Validar tipo de archivo permitido
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (in_array($_FILES["imagen"]["type"], $tiposPermitidos)) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
            $imagen = $rutaArchivo;
        } else {
            die("Error: No se pudo mover la imagen al destino. Verifica permisos de la carpeta.");
        }
    } else {
        die("Error: Formato de imagen no permitido.");
    }
}

// Validación de combustible
$valores_combustible = ['Gasolina', 'Diésel', 'Eléctrico', 'Híbrido'];
if (!in_array($combustible, $valores_combustible)) {
    die("Valor de combustible no válido.");
}

// Actualizar en la base de datos
$stmt = $conn->prepare("UPDATE $tabla SET marca=?, modelo=?, anio=?, color=?, tipo=?, presupuesto=?, kilometros=?, imagen=?, combustible=?, potencia_cv=? WHERE id=?");
$stmt->bind_param("ssisssdssdi", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $imagen, $combustible, $potencia_cv, $id);

if ($stmt->execute()) {
    // Ahora, si existe un wp_post_id, actualizamos el producto de WooCommerce
    if (!empty($wp_post_id) && function_exists('wp_update_post')) {
        // Construimos el título y el contenido (puedes ajustarlos según necesites)
        $titulo = $marca . ' ' . $modelo . ' ' . $anio;
        $contenido = "Color: $color\nTipo: $tipo\nCombustible: $combustible\nKilómetros: $kilometros\nPotencia: $potencia_cv CV";

        // 1️⃣ Actualizar el post (título y contenido)
        $post_data = array(
            'ID' => $wp_post_id,
            'post_title' => $titulo,
            'post_content' => $contenido
        );
        wp_update_post($post_data);

        // 2️⃣ Actualizar el precio (meta_key: _price y _regular_price)
        update_post_meta($wp_post_id, '_price', $presupuesto);
        update_post_meta($wp_post_id, '_regular_price', $presupuesto);

        // 3️⃣ Actualizar imagen destacada (opcional)
        if (!empty($imagen)) {
            // Asegúrate de tener una función para manejar la imagen destacada en WordPress
            // Por ejemplo, podrías usar media_sideload_image o similar si quieres vincular la imagen física.
            // Aquí por simplicidad, lo dejamos como comentario:
            // set_post_thumbnail($wp_post_id, $attachment_id);
        }

        // 4️⃣ Actualizar otros campos personalizados si los tienes
        update_post_meta($wp_post_id, 'kilometros', $kilometros);
        update_post_meta($wp_post_id, 'combustible', $combustible);
        update_post_meta($wp_post_id, 'potencia_cv', $potencia_cv);
        update_post_meta($wp_post_id, 'anio', $anio);
        update_post_meta($wp_post_id, 'color', $color);
    }

    header("Location: adminDashboard.php?msg=editado");
    exit;
} else {
    echo "Error al guardar: " . $stmt->error;
}
?>
