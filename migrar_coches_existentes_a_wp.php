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

// 1. Obtener coches de ambas tablas que NO tienen un wp_post_id (o que tienen 0)
// Usamos UNION ALL para combinar los resultados de vehiculos_km0 y coche_usuario.
// Añadimos una columna 'source_table' para saber de dónde viene el coche.
// También incluimos el 'telefono' y 'usuario_id' de coche_usuario que no existen en vehiculos_km0.
$sql = "(SELECT 
            id, marca, modelo, anio, color, tipo, presupuesto, kilometros, 
            combustible, potencia_cv, imagen, NULL as telefono, NULL as usuario_id,
            'km0' as source_table 
         FROM vehiculos_km0 
         WHERE wp_post_id IS NULL OR wp_post_id = 0)
        UNION ALL
        (SELECT 
            id, marca, modelo, anio, color, tipo, presupuesto, kilometros, 
            combustible, potencia_cv, imagen, telefono, usuario_id,
            'usuario' as source_table 
         FROM coche_usuario 
         WHERE wp_post_id IS NULL OR wp_post_id = 0)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p>Se encontraron " . $result->num_rows . " vehículos sin ID de WordPress para migrar.</p>";
    while ($coche_local = $result->fetch_assoc()) {
        $vehiculo_local_id = $coche_local['id'];
        $source_table = $coche_local['source_table'];

        echo "<hr><p>Procesando vehículo local ID: " . $vehiculo_local_id . " de tabla: " . $source_table . " (" . $coche_local['marca'] . " " . $coche_local['modelo'] . " " . $coche_local['anio'] . ")...</p>";

        // Prepara los datos para WordPress
        $wp_coche_nombre = $coche_local['marca'] . ' ' . $coche_local['modelo'] . ' ' . $coche_local['anio'];
        // Añadir distinción para coches de usuario en el título si lo deseas
        if ($source_table === 'usuario') {
            $wp_coche_nombre .= ' (Vehículo de Usuario)'; 
        }
        
        $wp_coche_descripcion = 'Color: ' . $coche_local['color'] . '<br>' .
                                'Combustible: ' . $coche_local['combustible'] . '<br>' .
                                'Potencia: ' . $coche_local['potencia_cv'] . ' CV<br>' .
                                'Tipo: ' . $coche_local['tipo'] . '<br>' .
                                'Kilómetros: ' . $coche_local['kilometros'] . ' km';
        
        // Si es un coche de usuario, añade el teléfono a la descripción
        if ($source_table === 'usuario' && !empty($coche_local['telefono'])) {
            $wp_coche_descripcion .= '<br>Teléfono de Contacto: ' . $coche_local['telefono'];
            // Opcional: Si quieres mostrar el nombre del usuario vendedor (requeriría otra consulta a la tabla 'usuarios' usando $coche_local['usuario_id'])
            // $nombre_usuario = obtener_nombre_usuario_por_id($coche_local['usuario_id']);
            // $wp_coche_descripcion .= '<br>Vendido por: ' . $nombre_usuario;
        }

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

            // Opcional: Asignar una categoría al producto (ej. 'vehiculos-km0' o 'vehiculos-usuario')
            $category_slug = ($source_table === 'km0') ? 'vehiculos-km0' : 'vehiculos-usuario'; // Ajusta slugs
            $term = get_term_by('slug', $category_slug, 'product_cat');
            if ($term) {
                wp_set_object_terms($post_id, $term->term_id, 'product_cat');
            } else {
                error_log("Categoría de producto no encontrada para slug: " . $category_slug);
                // Opcional: Crear la categoría si no existe: wp_insert_term($category_slug, 'product_cat');
            }

            // 3. Procesar y subir la imagen a la biblioteca de medios de WordPress
            if (!empty($coche_imagen_url)) {
                // Asegúrate de que la ruta de la imagen local es correcta.
                // Si 'imagen' en tu DB ya incluye 'images/', solo necesita __DIR__ . '/'
                // Si solo guarda el nombre del archivo, necesitarás __DIR__ . '/images/' .
                $imagen_path_abs = __DIR__ . '/' . $coche_imagen_url; 

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
                        error_log("Error al subir imagen para coche ID " . $vehiculo_local_id . " de " . $source_table . ": " . $attachment_id->get_error_message());
                    }
                } else {
                    echo "<p style='color: orange;'>⚠️ Aviso: La imagen local '" . $coche_imagen_url . "' no se encontró en el servidor.</p>";
                }
            } else {
                echo "<p>No hay imagen asignada para este vehículo local.</p>";
            }

            // 4. Actualizar tu base de datos local con el ID de WordPress (en la tabla correcta)
            $sql_update_local = "UPDATE " . $source_table . " SET wp_post_id = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update_local);
            if ($stmt_update) {
                $stmt_update->bind_param("ii", $post_id, $vehiculo_local_id);
                if ($stmt_update->execute()) {
                    echo "<p style='color: green;'>✔️ ID de WordPress (" . $post_id . ") guardado en tu DB local para vehículo ID " . $vehiculo_local_id . " (Tabla: " . $source_table . ").</p>";
                } else {
                    echo "<p style='color: red;'>❌ ERROR: No se pudo actualizar wp_post_id en tu DB local (" . $source_table . "): " . $stmt_update->error . "</p>";
                    error_log("Fallo al actualizar wp_post_id para vehiculo_local_id " . $vehiculo_local_id . " en " . $source_table . ": " . $stmt_update->error);
                }
                $stmt_update->close();
            } else {
                echo "<p style='color: red;'>❌ ERROR: No se pudo preparar la consulta para actualizar wp_post_id en " . $source_table . ": " . $conn->error . "</p>";
                error_log("Error al preparar update wp_post_id para coche ID " . $vehiculo_local_id . " en " . $source_table . ": " . $conn->error);
            }

        } else {
            echo "<p style='color: red;'>❌ ERROR: No se pudo crear el producto en WordPress para vehículo local ID " . $vehiculo_local_id . " de " . $source_table . ".</p>";
            error_log("Fallo al crear producto WP para coche ID " . $vehiculo_local_id . " de " . $source_table . ".");
        }
    }
} else {
    echo "<p>No se encontraron vehículos sin ID de WordPress para migrar en tus bases de datos.</p>";
}

$conn->close();
echo "<h2>Proceso de migración finalizado.</h2>";
?>