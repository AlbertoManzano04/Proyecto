<?php
session_start();

require_once __DIR__ . '/config/configBD.php';
require_once __DIR__ . '/tienda/wp-load.php';

require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Iniciando limpieza de vehículos huérfanos en WordPress...</h1>";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("<p style='color:red;'>Error conexión DB local: " . $conn->connect_error . "</p>");
}

// 1) IDs en base local (vehiculos_km0 + coche_usuario)
$ids_en_db_local = [];

// Obtener IDs vehiculos_km0
$sql_km0 = "SELECT wp_post_id FROM vehiculos_km0 WHERE wp_post_id IS NOT NULL AND wp_post_id != 0";
if ($result = $conn->query($sql_km0)) {
    while ($row = $result->fetch_assoc()) {
        $ids_en_db_local[] = (int)$row['wp_post_id'];
    }
    $result->free();
} else {
    die("<p style='color:red;'>Error SQL KM0: " . $conn->error . "</p>");
}

// Obtener IDs coche_usuario
$sql_usuario = "SELECT wp_post_id FROM coche_usuario WHERE wp_post_id IS NOT NULL AND wp_post_id != 0";
if ($result = $conn->query($sql_usuario)) {
    while ($row = $result->fetch_assoc()) {
        $ids_en_db_local[] = (int)$row['wp_post_id'];
    }
    $result->free();
} else {
    die("<p style='color:red;'>Error SQL Usuario: " . $conn->error . "</p>");
}

$ids_en_db_local = array_unique($ids_en_db_local);

// Ordenar de mayor a menor
rsort($ids_en_db_local);

echo "<p><b>IDs en base local (orden descendente):</b> (" . count($ids_en_db_local) . ") " . implode(', ', $ids_en_db_local) . "</p>";

// 2) IDs en WordPress WooCommerce (post_type=product)
$args = [
    'post_type'      => 'product',
    'post_status'    => ['publish', 'pending', 'draft', 'private', 'inherit', 'trash'],
    'posts_per_page' => -1,
    'fields'         => 'ids',
];
$query = new WP_Query($args);
$ids_en_wordpress = $query->posts;

// Ordenar de mayor a menor
rsort($ids_en_wordpress);

echo "<p><b>IDs en WordPress (productos, orden descendente):</b> (" . count($ids_en_wordpress) . ") " . implode(', ', $ids_en_wordpress) . "</p>";

// 3) Detectar IDs en WP que NO estén en la base local
$ids_huerfanos = array_diff($ids_en_wordpress, $ids_en_db_local);

// Ordenar huérfanos también para visualización
rsort($ids_huerfanos);

echo "<p><b>IDs huérfanos (en WP pero NO en BD local, orden descendente):</b> (" . count($ids_huerfanos) . ") " . implode(', ', $ids_huerfanos) . "</p>";

if (empty($ids_huerfanos)) {
    echo "<p style='color:green;'>No hay vehículos huérfanos para eliminar.</p>";
} else {
    echo "<p style='color:orange;'>Eliminando vehículos huérfanos...</p>";
    foreach ($ids_huerfanos as $post_id) {
        $titulo = get_the_title($post_id);
        if (!$titulo) $titulo = "(sin título)";

        // Borrar imagen destacada
        $thumbnail_id = get_post_thumbnail_id($post_id);
        if ($thumbnail_id) {
            if (wp_delete_attachment($thumbnail_id, true)) {
                echo "<p>Imagen destacada del vehículo '$titulo' (ID $thumbnail_id) eliminada.</p>";
            } else {
                echo "<p style='color:red;'>Error eliminando imagen destacada ID $thumbnail_id para '$titulo'</p>";
            }
        }

        // Borrar el producto de WordPress
        $resultado = wp_delete_post($post_id, true);
        if ($resultado) {
            echo "<p style='color:green;'>✔️ Vehículo '$titulo' (ID $post_id) eliminado correctamente.</p>";
        } else {
            echo "<p style='color:red;'>❌ Error eliminando vehículo '$titulo' (ID $post_id).</p>";
        }
    }
    echo "<p style='color:green;'>Eliminación completada.</p>";
}

$conn->close();

echo "<h2>Proceso finalizado.</h2>";

// Botón para volver al panel admin con estilo CSS inline
echo <<<HTML
<style>
  .btn-volver {
    display: inline-block;
    background-color: #0073aa; /* color azul WP admin */
    color: #fff;
    padding: 10px 20px;
    margin: 20px 0;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 600;
    font-family: Arial, sans-serif;
    box-shadow: 0 1px 0 #006799;
    transition: background-color 0.3s ease;
  }
  .btn-volver:hover {
    background-color: #005177;
    text-decoration: none;
    color: #fff;
  }
</style>

<a href="adminDashboard.php" class="btn-volver">← Volver al Panel Admin</a>
HTML;
?>
