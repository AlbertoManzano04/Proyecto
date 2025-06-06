<?php
// Iniciar sesión
session_start();

// Incluir archivo de configuración de base de datos
require_once './config/configBD.php';

// Incluir WordPress si necesitas usar wp_delete_post()
require_once __DIR__ . '/tienda/wp-load.php'; // Ajusta la ruta según la estructura de tu proyecto

// Crear conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar si la conexión ha fallado
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se pasó un ID en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtener el ID del vehículo a eliminar
    $id = $_GET['id'];

    // Iniciar una transacción para asegurar la coherencia de los datos
    $conn->begin_transaction();

    try {
        // Verificar si el vehículo pertenece al concesionario o al usuario
        $sqlVerificarTipo = "SELECT kilometros FROM vehiculos_km0 WHERE id = ? 
                             UNION 
                             SELECT kilometros FROM coche_usuario WHERE id = ?";
        if ($stmt = $conn->prepare($sqlVerificarTipo)) {
            $stmt->bind_param("ii", $id, $id); // Verificar en ambas tablas
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($kilometros);
            $stmt->fetch();
            $stmt->close();

            // Si el vehículo tiene 0 km, es del concesionario
            if ($kilometros == 0) {
                // Eliminar las referencias en la tabla usuarios_favoritos
                $sqlEliminarFavoritos = "DELETE FROM usuarios_favoritos WHERE vehiculo_id = ?";
                if ($stmt = $conn->prepare($sqlEliminarFavoritos)) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    throw new Exception("Error al eliminar favoritos: " . $conn->error);
                }

                // Eliminar el vehículo del concesionario
                $sqlEliminarVehiculo = "DELETE FROM vehiculos_km0 WHERE id = ?";
                if ($stmt = $conn->prepare($sqlEliminarVehiculo)) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    throw new Exception("Error al eliminar el vehículo del concesionario: " . $conn->error);
                }
            } else {
                // Vehículo con kilometraje > 0 es de un usuario

                // 1️⃣ Obtener el wp_post_id antes de eliminarlo
                $sqlGetWpPostId = "SELECT wp_post_id FROM coche_usuario WHERE id = ?";
                if ($stmt = $conn->prepare($sqlGetWpPostId)) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($wp_post_id);
                    $stmt->fetch();
                    $stmt->close();
                } else {
                    throw new Exception("Error al obtener el wp_post_id: " . $conn->error);
                }

                // 2️⃣ Eliminar el vehículo de la tabla coche_usuario
                $sqlEliminarVehiculo = "DELETE FROM coche_usuario WHERE id = ?";
                if ($stmt = $conn->prepare($sqlEliminarVehiculo)) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    throw new Exception("Error al eliminar el vehículo del usuario: " . $conn->error);
                }

                // 3️⃣ Eliminar el producto de WooCommerce (si existe)
                if (!empty($wp_post_id)) {
                    if (function_exists('wp_delete_post')) {
                        wp_delete_post($wp_post_id, true); // true => borrar permanentemente
                    } else {
                        throw new Exception("wp_delete_post() no está disponible.");
                    }
                }
            }

            // 🚨 Aquí añadimos la limpieza de huérfanos
            // 1️⃣ Obtener todos los IDs de productos en WordPress
            $sqlProductos = "SELECT ID FROM wp_posts WHERE post_type = 'product'";
            $result = $conn->query($sqlProductos);

            if (!$result) {
                throw new Exception("Error al obtener productos: " . $conn->error);
            }

            while ($row = $result->fetch_assoc()) {
                $wp_post_id = $row['ID'];

                // Verificar si está en vehiculos_km0
                $sqlCheckKm0 = "SELECT id FROM vehiculos_km0 WHERE wp_post_id = ?";
                $stmtKm0 = $conn->prepare($sqlCheckKm0);
                $stmtKm0->bind_param("i", $wp_post_id);
                $stmtKm0->execute();
                $stmtKm0->store_result();

                // Verificar si está en coche_usuario
                $sqlCheckUsuario = "SELECT id FROM coche_usuario WHERE wp_post_id = ?";
                $stmtUsuario = $conn->prepare($sqlCheckUsuario);
                $stmtUsuario->bind_param("i", $wp_post_id);
                $stmtUsuario->execute();
                $stmtUsuario->store_result();

                // Si no está en ninguna tabla, lo eliminamos de WordPress
                if ($stmtKm0->num_rows == 0 && $stmtUsuario->num_rows == 0) {
                    if (function_exists('wp_delete_post')) {
                        wp_delete_post($wp_post_id, true);
                    }
                }

                $stmtKm0->close();
                $stmtUsuario->close();
            }

            $result->free();

        } else {
            throw new Exception("Error al verificar el vehículo: " . $conn->error);
        }

        // Si todo fue bien, confirmamos la transacción
        $conn->commit();

        // Redirigir al panel de administración
        header("Location: adminDashboard.php");
        exit();

    } catch (Exception $e) {
        // Si hubo un error, deshacer la transacción y mostrar el error
        $conn->rollback();
        echo "Error al eliminar el vehículo: " . htmlspecialchars($e->getMessage());
    }
} else {
    // Si no se pasa el id en la URL
    echo "ID no válido.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
