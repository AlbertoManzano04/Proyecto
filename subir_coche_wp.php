<?php
// subir_coche_wp.php

// Incluir el núcleo de WordPress. Asegúrate de que esta ruta sea ABSOLUTA y correcta.
require_once(__DIR__ . '/tienda/wp-load.php');
// Incluir tu configuración de base de datos local para poder actualizar tu tabla.
require_once(__DIR__ . '/config/configBD.php');

// Activar la visualización de errores solo para depuración. ¡Desactiva esto en producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Recoge datos de la URL (GET request)
$vehiculo_local_id = intval($_GET['vehiculo_id'] ?? 0); // El ID de tu tabla vehiculos_km0
$coche_nombre = $_GET['nombre'] ?? '';
$coche_descripcion = $_GET['descripcion'] ?? '';
$coche_precio = floatval($_GET['precio'] ?? 0);
$coche_imagen_url = $_GET['imagen_url'] ?? ''; // La ruta relativa de la imagen local

// Validación básica de los datos recibidos. Si algo falla, redirige.
if ($vehiculo_local_id === 0 || empty($coche_nombre) || empty($coche_descripcion) || $coche_precio <= 0) {
    header("Location: adminDashboard.php?error=Datos inválidos o incompletos para subir a WordPress.");
    exit();
}

// 1. Crear el producto en WooCommerce
$post_id = wp_insert_post(array(
    'post_title'    => $coche_nombre,
    'post_content'  => $coche_descripcion,
    'post_status'   => 'publish', // Publicar el producto inmediatamente
    'post_type'     => 'product'  // Definir como tipo de post 'producto' de WooCommerce
));

if ($post_id) {
    // El producto se creó con éxito en WordPress. Ahora asigna los meta-datos de WooCommerce.
    update_post_meta($post_id, '_regular_price', $coche_precio);
    update_post_meta($post_id, '_price', $coche_precio);
    update_post_meta($post_id, '_stock_status', 'instock'); // Establecer como 'en stock'
    update_post_meta($post_id, '_manage_stock', 'no');      // No gestionar stock

    // 2. Procesar y subir la imagen a la biblioteca de medios de WordPress
    if (!empty($coche_imagen_url)) {
        // Construir la ruta absoluta de la imagen en tu servidor
        $imagen_path_abs = __DIR__ . '/' . $coche_imagen_url;

        if (file_exists($imagen_path_abs)) {
            // Incluir archivos necesarios de WordPress para el manejo de medios
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            // Preparar los datos del archivo para media_handle_sideload
            $file_array = array(
                'name'     => basename($imagen_path_abs), // Nombre del archivo
                'tmp_name' => $imagen_path_abs,            // Ruta temporal (aquí es la ruta absoluta del archivo)
                'error'    => 0,
                'size'     => filesize($imagen_path_abs),
                'type'     => mime_content_type($imagen_path_abs)
            );

            // Subir la imagen a la biblioteca de medios de WordPress y asociarla al producto
            $attachment_id = media_handle_sideload($file_array, $post_id);

            if ( ! is_wp_error( $attachment_id ) ) {
                set_post_thumbnail( $post_id, $attachment_id ); // Establecer como imagen destacada del producto
            } else {
                error_log("Error al subir imagen a WordPress con media_handle_sideload(): " . $attachment_id->get_error_message());
            }
        } else {
            error_log("Imagen no encontrada en la ruta especificada para WordPress: " . $imagen_path_abs);
        }
    }

    // 3. --- ¡Paso CRÍTICO! Guardar el ID del producto de WordPress en tu tabla vehiculos_km0 ---
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        error_log("Error al conectar a la BD local para actualizar wp_post_id: " . $conn->connect_error);
        // El producto ya está en WP, pero aquí podemos redirigir con un error si la conexión a la BD local falla.
        header("Location: adminDashboard.php?error=Error interno al guardar ID de WordPress en la BD local.");
        exit();
    }

    $update_sql = "UPDATE vehiculos_km0 SET wp_post_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    if ($stmt) {
        $stmt->bind_param("ii", $post_id, $vehiculo_local_id); // $post_id es el ID de WordPress, $vehiculo_local_id es tu ID
        if (!$stmt->execute()) {
            error_log("Fallo al actualizar wp_post_id para vehiculo_km0 ID " . $vehiculo_local_id . ": " . $stmt->error);
            // Aquí podríamos redirigir con un error específico si queremos.
            header("Location: adminDashboard.php?error=Error al actualizar el ID de WordPress en tu base de datos local.");
            exit();
        }
        $stmt->close();
    } else {
        error_log("Error al preparar la consulta para actualizar wp_post_id: " . $conn->error);
        header("Location: adminDashboard.php?error=Error interno al preparar la actualización del ID de WordPress.");
        exit();
    }
    $conn->close();
    // --- FIN Paso CRÍTICO ---

    // 4. Redirigir al panel de administración con un mensaje de éxito
    header("Location: adminDashboard.php?message=Vehículo subido a la base de datos y a WooCommerce con ID $post_id con éxito!");
    exit();
} else {
    // Si la creación del producto en WordPress falló
    header("Location: adminDashboard.php?error=Error al crear el producto en WooCommerce.");
    exit();
}
?>
