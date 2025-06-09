<?php
require_once './config/configBD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $tipo = $_POST['tipo'];
    $presupuesto = $_POST['presupuesto'];
    $kilometros = $_POST['kilometros'];
    $potencia_cv = $_POST['potencia_cv'];
    $combustible = $_POST['combustible'];

    // Imagen
    $imagen = $_FILES['imagen'];

    if ($imagen['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = basename($imagen['name']);
        $rutaDestino = 'images/' . $nombreImagen;

        // Si la imagen ya está en images/ no hace falta moverla
        // Para evitar error al mover desde el temporal
        if (!file_exists($rutaDestino)) {
            if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                die("Error al mover la imagen");
            }
        }
        // En cualquier caso, guardamos la ruta en la BD como images/nombreimagen
    } else {
        die("Error al subir la imagen");
    }

    // Inserta en la base de datos la ruta relativa (images/nombreimagen)
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Guardamos la ruta relativa en la BD (images/nombreimagen)
    $rutaRelativaImagen = 'images/' . $nombreImagen;

    $stmt = $conn->prepare("INSERT INTO vehiculos_km0 (marca, modelo, anio, color, tipo, presupuesto, kilometros, potencia_cv, combustible, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissdiiss", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $potencia_cv, $combustible, $rutaRelativaImagen);

    if ($stmt->execute()) {
        $vehiculo_local_id = $stmt->insert_id;
        $stmt->close();
        $conn->close();

        $wp_coche_nombre = $marca . ' ' . $modelo . ' ' . $anio . '';
        $wp_coche_descripcion = 'Color: ' . $color . '<br>' .
                                'Combustible: ' . $combustible . '<br>' .
                                'Potencia: ' . $potencia_cv . ' CV<br>' .
                                'Tipo: ' . $tipo . '<br>' .
                                'Kilómetros: ' . $kilometros . ' km<br>' .
                                'Teléfono de Contacto: ' . $telefono;
        $wp_coche_precio = $presupuesto;

        header("Location: /php/Proyecto/subir_coche_wp.php?" .
               "vehiculo_id=" . urlencode($vehiculo_local_id) . "&" .
               "tipo_coche=" . urlencode('cocncesionario') . "&" .
               "nombre=" . urlencode($wp_coche_nombre) . "&" .
               "descripcion=" . urlencode($wp_coche_descripcion) . "&" .
               "precio=" . urlencode($wp_coche_precio) . "&" .
               "imagen_url=" . urlencode($imagenRutaRelativa));
        exit();
    } else {
        echo "<script>alert('Error al subir el coche a la base de datos: " . $stmt->error . "'); window.location.href='subeTuCoche.php';</script>";
    }


    $stmt->close();
    $conn->close();
}
?>










