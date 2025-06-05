<?php
// migrar_coches_existentes_a_wp.php
require_once __DIR__ . '/config/configBD.php';
require_once __DIR__ . '/tienda/wp-load.php';

require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Migración de Coches a WordPress</title>
<style>
  body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #f1f1f1;
    margin: 20px;
    color: #23282d;
  }
  h1, h2 {
    color: #0073aa;
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
  }
  p {
    line-height: 1.5;
  }
  hr {
    border: none;
    border-top: 1px solid #ccc;
    margin: 20px 0;
  }
  .btn {
    display: inline-block;
    background: #0073aa;
    color: white;
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 3px;
    font-weight: 600;
    margin: 20px 0;
    transition: background-color 0.2s ease-in-out;
  }
  .btn:hover {
    background: #005177;
  }
  .message {
    padding: 8px 12px;
    margin: 8px 0;
    border-radius: 3px;
  }
  .success {
    background: #dff0d8;
    border: 1px solid #3c763d;
    color: #3c763d;
  }
  .error {
    background: #f2dede;
    border: 1px solid #a94442;
    color: #a94442;
  }
  .warning {
    background: #fcf8e3;
    border: 1px solid #8a6d3b;
    color: #8a6d3b;
  }
  .info {
    background: #d9edf7;
    border: 1px solid #31708f;
    color: #31708f;
  }
</style>
</head>
<body>

<?php

echo "<h1>Iniciando migración/verificación de coches a WordPress...</h1>";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("<p class='message error'>Error de conexión a la base de datos local: " . $conn->connect_error . "</p></body></html>");
}

$sql = "(SELECT 
            id, marca, modelo, anio, color, tipo, presupuesto, kilometros, 
            combustible, potencia_cv, imagen, wp_post_id, NULL as telefono, NULL as usuario_id,
            'vehiculos_km0' as source_table
         FROM vehiculos_km0)
        UNION ALL
        (SELECT 
            id, marca, modelo, anio, color, tipo, presupuesto, kilometros, 
            combustible, potencia_cv, imagen, wp_post_id, telefono, usuario_id,
            'coche_usuario' as source_table
         FROM coche_usuario)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p class='message info'>Se encontraron " . $result->num_rows . " vehículos en total para verificar/migrar.</p>";

    while ($coche_local = $result->fetch_assoc()) {
        $vehiculo_local_id = $coche_local['id'];
        $source_table = $coche_local['source_table'];
        $wp_post_id_local_db = $coche_local['wp_post_id'];

        echo "<hr><p>Procesando vehículo local ID: <strong>" . $vehiculo_local_id . "</strong> de tabla: <strong>" . $source_table . "</strong> (" . htmlspecialchars($coche_local['marca']) . " " . htmlspecialchars($coche_local['modelo']) . " " . htmlspecialchars($coche_local['anio']) . ")...</p>";

        $is_wp_product_valid = false;
        if (!empty($wp_post_id_local_db) && $wp_post_id_local_db > 0) {
            $existing_wp_post = get_post($wp_post_id_local_db);
            if ($existing_wp_post && $existing_wp_post->post_type === 'product' && $existing_wp_post->post_status !== 'trash') {
                $is_wp_product_valid = true;
            }
        }

        $wp_coche_precio = $coche_local['presupuesto'];

        if ($is_wp_product_valid) {
            echo "<p class='message info'>✅ Este vehículo ya está en WordPress con ID válido: <strong>" . $wp_post_id_local_db . "</strong>. Actualizando el precio...</p>";

            update_post_meta($wp_post_id_local_db, '_regular_price', $wp_coche_precio);
            update_post_meta($wp_post_id_local_db, '_price', $wp_coche_precio);
            echo "<p class='message success'>✔️ Precio actualizado correctamente para el producto con ID <strong>$wp_post_id_local_db</strong>.</p>";

            continue;
        }

        echo "<p>🚀 Este vehículo no está migrado o tiene un ID inválido. Se intentará crear.</p>";

        $wp_coche_nombre = $coche_local['marca'] . ' ' . $coche_local['modelo'] . ' ' . $coche_local['anio'];
        if ($source_table === 'coche_usuario') {
            $wp_coche_nombre .= ' (Vehículo de Usuario)';
        }

        $wp_coche_descripcion = 'Color: ' . $coche_local['color'] . '<br>' .
                                'Combustible: ' . $coche_local['combustible'] . '<br>' .
                                'Potencia: ' . $coche_local['potencia_cv'] . ' CV<br>' .
                                'Tipo: ' . $coche_local['tipo'] . '<br>' .
                                'Kilómetros: ' . $coche_local['kilometros'] . ' km';

        if ($source_table === 'coche_usuario' && !empty($coche_local['telefono'])) {
            $wp_coche_descripcion .= '<br>Teléfono de Contacto: ' . htmlspecialchars($coche_local['telefono']);
        }

        $post_id = wp_insert_post(array(
            'post_title'    => $wp_coche_nombre,
            'post_content'  => $wp_coche_descripcion,
            'post_status'   => 'publish',
            'post_type'     => 'product'
        ));

        if ($post_id) {
            echo "<p class='message success'>✔️ Producto creado en WordPress con ID: <strong>" . $post_id . "</strong></p>";

            update_post_meta($post_id, '_regular_price', $wp_coche_precio);
            update_post_meta($post_id, '_price', $wp_coche_precio);
            update_post_meta($post_id, '_stock_status', 'instock');
            update_post_meta($post_id, '_manage_stock', 'no');

            $category_slug = ($source_table === 'vehiculos_km0') ? 'vehiculos-km0' : 'vehiculos-usuario';
            $term = get_term_by('slug', $category_slug, 'product_cat');
            if ($term) {
                wp_set_object_terms($post_id, $term->term_id, 'product_cat');
            } else {
                echo "<p class='message warning'>⚠️ Categoría '$category_slug' no encontrada. Créala manualmente.</p>";
            }

            if (!empty($coche_local['imagen'])) {
                $carpeta_imagenes = __DIR__ . 'images/';
                $nombre_archivo = basename($coche_local['imagen']);
                $imagen_path_abs = $carpeta_imagenes . $nombre_archivo;

                if (file_exists($imagen_path_abs)) {
                    $file_array = array(
                        'name'     => $nombre_archivo,
                        'tmp_name' => $imagen_path_abs,
                        'error'    => 0,
                        'size'     => filesize($imagen_path_abs),
                        'type'     => mime_content_type($imagen_path_abs)
                    );

                    $attachment_id = media_handle_sideload($file_array, $post_id);
                    if (!is_wp_error($attachment_id)) {
                        set_post_thumbnail($post_id, $attachment_id);
                        echo "<p class='message success'>✔️ Imagen subida correctamente.</p>";
                    } else {
                        echo "<p class='message warning'>⚠️ Error al subir imagen: " . $attachment_id->get_error_message() . "</p>";
                    }
                } else {
                    echo "<p class='message warning'>⚠️ Imagen no encontrada en: " . htmlspecialchars($imagen_path_abs) . "</p>";
                }
            }

            $sql_update_local = "UPDATE " . $source_table . " SET wp_post_id = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update_local);
            if ($stmt_update) {
                $stmt_update->bind_param("ii", $post_id, $vehiculo_local_id);
                if ($stmt_update->execute()) {
                    echo "<p class='message success'>✔️ ID de WordPress guardado en tu DB local.</p>";
                } else {
                    echo "<p class='message error'>❌ ERROR: No se pudo actualizar el ID en la DB local: " . $stmt_update->error . "</p>";
                }
                $stmt_update->close();
            }
        } else {
            echo "<p class='message error'>❌ ERROR: No se pudo crear el producto en WordPress para el vehículo.</p>";
        }
    }
} else {
    echo "<p>No se encontraron vehículos en tus bases de datos.</p>";
}

$conn->close();

echo "<h2>Proceso de migración/verificación finalizado.</h2>";
?>
<a href="adminDashboard.php" class="btn" role="button">← Volver al Panel</a>
</body>
</html>
