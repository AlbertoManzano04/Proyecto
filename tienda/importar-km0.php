<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/wp-load.php';

global $wpdb;

$vehiculos = $wpdb->get_results("SELECT * FROM vehiculos_km0");

if (!$vehiculos) {
    die('No se encontraron vehículos km0 o error en la consulta.');
}

foreach ($vehiculos as $vehiculo) {
    // Comprobamos si ya existe un producto con este SKU (usamos el id del vehículo)
    $existing_product_id = $wpdb->get_var($wpdb->prepare("
        SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key='_sku' AND meta_value=%s
    ", $vehiculo->id));

    if ($existing_product_id) {
        echo "Producto con SKU {$vehiculo->id} ya existe. <br>";
        continue;
    }

    $product = new WC_Product_Simple();
    $product->set_name($vehiculo->marca . ' ' . $vehiculo->modelo);
    $product->set_description('Vehículo Km0, tipo ' . $vehiculo->tipo . ', año ' . $vehiculo->anio);
    $product->set_price($vehiculo->presupuesto);
    $product->set_regular_price($vehiculo->presupuesto);
    $product->set_sku($vehiculo->id);
    $product->set_status('publish');

    $product_id = $product->save();

    if ($product_id) {
        echo "Producto {$product->get_name()} creado con ID: $product_id <br>";
    } else {
        echo "Error creando producto para vehículo ID {$vehiculo->id} <br>";
    }
}
?>