<?php
// migrar_coches_existentes_a_wp.php
// ¡¡ADVERTENCIA!!
// ANTES DE EJECUTAR ESTE SCRIPT, HAZ UNA COPIA DE SEGURIDAD COMPLETA DE TU BASE DE DATOS Y DE WORDPRESS.
// Este script insertará datos en WordPress y modificará tu base de datos.

// Incluir tu configuración de base de datos local
require_once __DIR__ . '/config/configBD.php';

// Incluir el núcleo de WordPress
require_once __DIR__ . '/tienda/wp-load.php';

// Cargar funciones de WordPress necesarias para crear posts y medios
require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

// Activar la visualización de errores solo para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Iniciando migración de coches existentes a WordPress...</h1>";

// Conexión a la base de datos local
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("<p style='color: red;'>Error de conexión a la base de datos local: " . $conn->connect_error . "</p>");
}

// 1. Obtener coches de vehiculos_km0 que NO tienen un wp_post_id O que tienen wp_post_id pero el producto no existe en WP
// Para simplificar, primero nos enfocamos en los que no tienen wp_post_id.
// Si ya tienen wp_post_id, asumimos que ya están en WP o se eliminarán con el script de limpieza.
$sql = "SELECT id, marca, modelo, anio, color, tipo, presupuesto, kilometros, potencia_cv, combustible, imagen 
        FROM vehiculos_km0 
        WHERE wp_post_id IS NULL AND kilometros = 0"; // Solo KM0, y solo si no tienen ID de WP
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p>Se encontraron " . $result->num_rows . " vehículos KM0 sin ID de WordPress para migrar.</p>";
    while ($coche_local = $result->fetch_assoc()) {
        $vehiculo_local_id = $coche_local['id'];

        echo "<hr><p>Procesando vehículo local ID: " . $vehiculo_local_id . " (" . $coche_local['marca'] . " " . $coche_local['modelo'] . " " . $coche_local['anio'] . ")...</p>";

        // Prepara los datos para WordPress
        $wp_coche_nombre = $coche_local['marca'] . ' ' . $coche_local['modelo'] . ' ' . $coche_local['anio'];
        $wp_coche_descripcion = 'Color: ' . $coche_local['color'] . '<br>' .
                                'Combustible: ' . $coche_local['combustible'] . '<br>' .
                                'Potencia: ' . $coche_local['potencia_cv'] . ' CV<br>' .
                                'Tipo: ' . $coche_local['tipo'] . '<br>' .
                                'Kilómetros: ' . $coche_local['kilometros'] . ' km';
        $wp_coche_precio = $coche_local['presupuesto'];
        $coche_imagen_url = $coche_local['imagen']; // Ruta relativa de la imagen local

        // 2. Crear el producto en WooCommerce
        $post_id = wp_insert_post(array(
            'post_title'    => $wp_coche_nombre,
            'post_content'  => $wp_coche_descripcion,
            'post_status'   => 'publish',
            'post_type'     => 'product'
        ));

        if ($post_id) {
            echo "<p style='color: blue;'>✔️ Producto creado en WordPress con ID: " . $post_id . "</p>";
            update_post_meta($post_id, '_regular_price', $wp_coche_precio);
            update_post_meta($post_id, '_price', $wp_coche_precio);
            update_post_meta($post_id, '_stock_status', 'instock');
            update_post_meta($post_id, '_manage_stock', 'no');

            // 3. Procesar y subir la imagen a la biblioteca de medios de WordPress
            if (!empty($coche_imagen_url)) {
                $imagen_path_abs = __DIR__ . '/images/' . $coche_imagen_url; // Ajusta la ruta si es necesario

                if (file_exists($imagen_path_abs)) {
                    $file_array = array(
                        'name'     => basename($imagen_path_abs),
                        'tmp_name' => $imagen_path_abs,
                        'error'    => 0,
                        'size'     => filesize($imagen_path_abs),
                        'type'     => mime_content_type($imagen_path_abs)
                    );

                    $attachment_id = media_handle_sideload($file_array, $post_id);

                    if ( ! is_wp_error( $attachment_id ) ) {
                        set_post_thumbnail( $post_id, $attachment_id );
                        echo "<p style='color: green;'>✔️ Imagen subida a WordPress y asignada como destacada.</p>";
                    } else {
                        echo "<p style='color: orange;'>⚠️ Error al subir imagen a WordPress: " . $attachment_id->get_error_message() . "</p>";
                        error_log("Error al subir imagen para coche ID " . $vehiculo_local_id . ": " . $attachment_id->get_error_message());
                    }
                } else {
                    echo "<p style='color: orange;'>⚠️ Aviso: La imagen local '" . $coche_imagen_url . "' no se encontró en el servidor.</p>";
                }
            } else {
                echo "<p>No hay imagen asignada para este vehículo local.</p>";
            }

            // 4. Actualizar tu base de datos local con el ID de WordPress
            $sql_update_local = "UPDATE vehiculos_km0 SET wp_post_id = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update_local);
            if ($stmt_update) {
                $stmt_update->bind_param("ii", $post_id, $vehiculo_local_id);
                if ($stmt_update->execute()) {
                    echo "<p style='color: green;'>✔️ ID de WordPress (" . $post_id . ") guardado en tu DB local para vehículo ID " . $vehiculo_local_id . ".</p>";
                } else {
                    echo "<p style='color: red;'>❌ ERROR: No se pudo actualizar wp_post_id en tu DB local: " . $stmt_update->error . "</p>";
                    error_log("Fallo al actualizar wp_post_id para vehiculo_km0 ID " . $vehiculo_local_id . ": " . $stmt_update->error);
                }
                $stmt_update->close();
            } else {
                echo "<p style='color: red;'>❌ ERROR: No se pudo preparar la consulta para actualizar wp_post_id: " . $conn->error . "</p>";
                error_log("Error al preparar update wp_post_id para coche ID " . $vehiculo_local_id . ": " . $conn->error);
            }

        } else {
            echo "<p style='color: red;'>❌ ERROR: No se pudo crear el producto en WordPress para vehículo local ID " . $vehiculo_local_id . ".</p>";
            error_log("Fallo al crear producto WP para coche ID " . $vehiculo_local_id . ".");
        }
    }
} else {
    echo "<p>No se encontraron vehículos KM0 sin ID de WordPress para migrar en tu base de datos.</p>";
}

$conn->close();
echo "<h2>Proceso de migración finalizado.</h2>";
?>