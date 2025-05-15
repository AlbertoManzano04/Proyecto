<?php
require_once __DIR__ . '/wp-load.php';

if (!class_exists('WooCommerce')) {
    die('WooCommerce no está activo');
}

global $wpdb;

$vehiculos = $wpdb->get_results("SELECT * FROM coche_usuario", ARRAY_A);

if (!$vehiculos) {
    die("No hay vehículos o error en la consulta.");
}

foreach ($vehiculos as $vehiculo) {
    $titulo = sanitize_text_field($vehiculo['marca'] . ' ' . $vehiculo['modelo']);

    $post = get_page_by_title($titulo, OBJECT, 'product');
    if ($post) {
        $product_id = $post->ID;
    } else {
        $post_id = wp_insert_post([
            'post_title'  => $titulo,
            'post_status' => 'publish',
            'post_type'   => 'product',
        ]);
        if (is_wp_error($post_id)) {
            echo "Error al crear producto: " . $post_id->get_error_message() . "<br>";
            continue;
        }
        $product_id = $post_id;
    }

    update_post_meta($product_id, '_regular_price', $vehiculo['presupuesto']);
    update_post_meta($product_id, '_price', $vehiculo['presupuesto']);
    update_post_meta($product_id, '_stock_status', 'instock');

    echo "Producto '{$titulo}' creado o actualizado.<br>";
}

echo "Importación terminada.";
