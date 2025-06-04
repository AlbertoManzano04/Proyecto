<?php
// sincronizar_eliminar_wp.php

// Iniciar sesión (opcional para scripts de limpieza, pero no hace daño)
session_start();

// --- Incluir la configuración de tu base de datos local ---
require_once __DIR__ . '/config/configBD.php';

// --- Incluir el núcleo de WordPress ---
require_once __DIR__ . '/tienda/wp-load.php';

// --- Cargar funciones de WordPress necesarias para la eliminación ---
require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

// Activar la visualización de errores solo para depuración. ¡Desactiva esto en producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Iniciando sincronización de limpieza de WordPress...</h1>";

// 1. Conectar a tu base de datos phpMyAdmin (local)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("<p style='color: red;'>Error de conexión a la base de datos local: " . $conn->connect_error . "</p>");
}

// 2. Obtener todos los wp_post_id que tienes registrados en tu tabla 'vehiculos_km0'
$ids_en_db_local = [];
// Solo seleccionamos los wp_post_id que NO son NULL, porque solo esos son los que se han subido a WordPress.
$sql_get_local_ids = "SELECT wp_post_id FROM vehiculos_km0 WHERE wp_post_id IS NOT NULL";
if ($result = $conn->query($sql_get_local_ids)) {
    while ($row = $result->fetch_assoc()) {
        $ids_en_db_local[] = $row['wp_post_id'];
    }
    $result->free();
} else {
    die("<p style='color: red;'>Error al obtener IDs de vehículos KM0 de tu base de datos: " . $conn->error . "</p>");
}
$conn->close();
echo "<p>Total de vehículos KM0 con ID de WordPress en tu DB local: " . count($ids_en_db_local) . "</p>";

// 3. Obtener todos los IDs de productos de WooCommerce
$ids_en_wordpress = [];
$args = array(
    'post_type'      => 'product', // Solo productos
    'post_status'    => array('publish', 'pending', 'draft', 'private', 'inherit', 'trash'), // Incluir los estados más comunes (auto-draft y future no suelen ser necesarios para limpieza)
    'posts_per_page' => -1,        // Obtener todos los productos
    'fields'         => 'ids',     // Solo obtener los IDs
    // Opcional: Si solo quieres eliminar productos de una categoría específica, por ejemplo 'vehiculos-km0'.
    // Descomenta y ajusta si usas categorías específicas para tus coches KM0.
    /*
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'coches-km0', // Cambia 'coches-km0' por la slug real de tu categoría de productos KM0
        )
    )
    */
);
$products_query = new WP_Query($args);
$ids_en_wordpress = $products_query->posts;

echo "<p>Total de productos encontrados en WordPress: " . count($ids_en_wordpress) . "</p>";

// 4. Identificar productos en WordPress que NO están en tu base de datos local
$ids_a_eliminar_de_wp = array_diff($ids_en_wordpress, $ids_en_db_local);

echo "<p>Productos de WordPress encontrados para eliminar (huérfanos): " . count($ids_a_eliminar_de_wp) . "</p>";

if (empty($ids_a_eliminar_de_wp)) {
    echo "<p style='color: green;'>¡Felicidades! No se encontraron productos huérfanos en WordPress que necesiten ser eliminados.</p>";
} else {
    echo "<p style='color: orange;'>Iniciando eliminación de productos huérfanos de WordPress...</p>";
    foreach ($ids_a_eliminar_de_wp as $wp_id_a_eliminar) {
        $product_title = get_the_title($wp_id_a_eliminar); // Obtener título para el log

        // Obtener el ID de la imagen destacada (thumbnail) si existe
        $thumbnail_id = get_post_thumbnail_id($wp_id_a_eliminar);

        // Eliminar el producto de WordPress de forma permanente
        $deleted = wp_delete_post($wp_id_a_eliminar, true); // 'true' para eliminación permanente

        if ($deleted) {
            // Si el producto se eliminó, también elimina la imagen destacada de la biblioteca de medios
            if ($thumbnail_id) {
                wp_delete_attachment($thumbnail_id, true); // Eliminar la imagen permanentemente
                echo "<p style='color: green;'>✔️ Producto '" . esc_html($product_title) . "' (ID WP: " . $wp_id_a_eliminar . ") eliminado de WordPress y su imagen destacada.</p>";
            } else {
                echo "<p style='color: green;'>✔️ Producto '" . esc_html($product_title) . "' (ID WP: " . $wp_id_a_eliminar . ") eliminado de WordPress (sin imagen destacada).</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ ERROR: No se pudo eliminar el producto '" . esc_html($product_title) . "' (ID WP: " . $wp_id_a_eliminar . ") de WordPress.</p>";
        }
    }
    echo "<p style='color: green;'>Proceso de limpieza completado.</p>";
}

echo "<h2>Proceso finalizado.</h2>";
?>