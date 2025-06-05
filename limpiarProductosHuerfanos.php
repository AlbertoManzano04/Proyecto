<?php
// Iniciar sesión
session_start();

// Incluir configuración de base de datos
require_once './config/configBD.php';

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar la conexión
if ($conn->connect_error) {
    die("<p class='error'>Conexión fallida: " . $conn->connect_error . "</p>");
}

// Iniciar transacción
$conn->begin_transaction();

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Limpieza Productos WordPress</title>
<style>
  /* Estilo básico tipo panel admin WP */
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
      Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
    background: #f1f1f1;
    color: #23282d;
    margin: 20px;
  }
  h2 {
    color: #0073aa;
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
  }
  p {
    font-size: 1rem;
    line-height: 1.5;
  }
  a {
    color: #0073aa;
    text-decoration: none;
    font-weight: 600;
  }
  a:hover {
    color: #005177;
  }
  .btn {
    display: inline-block;
    background: #0073aa;
    color: white;
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 3px;
    font-weight: 600;
    margin-top: 20px;
    transition: background-color 0.2s ease-in-out;
  }
  .btn:hover {
    background: #005177;
  }
  .success {
    background: #dff0d8;
    border: 1px solid #3c763d;
    color: #3c763d;
    padding: 10px 15px;
    border-radius: 3px;
    margin-bottom: 15px;
  }
  .error {
    background: #f2dede;
    border: 1px solid #a94442;
    color: #a94442;
    padding: 10px 15px;
    border-radius: 3px;
    margin-bottom: 15px;
  }
</style>
</head>
<body>

<?php
try {
    // Obtener todos los IDs de WordPress que representan productos de vehículos
    $sql = "SELECT ID FROM wp_posts WHERE post_type = 'product'";
    $result = $conn->query($sql);

    $productosEliminados = 0;

    while ($row = $result->fetch_assoc()) {
        $wp_post_id = $row['ID'];

        // Verificar si el ID está en vehiculos_km0
        $sqlCheckKm0 = "SELECT id FROM vehiculos_km0 WHERE wp_post_id = ?";
        $stmtKm0 = $conn->prepare($sqlCheckKm0);
        $stmtKm0->bind_param("i", $wp_post_id);
        $stmtKm0->execute();
        $stmtKm0->store_result();

        // Verificar si el ID está en coche_usuario
        $sqlCheckUsuario = "SELECT id FROM coche_usuario WHERE wp_post_id = ?";
        $stmtUsuario = $conn->prepare($sqlCheckUsuario);
        $stmtUsuario->bind_param("i", $wp_post_id);
        $stmtUsuario->execute();
        $stmtUsuario->store_result();

        // Si no está en ninguna de las dos tablas, eliminar el producto de WordPress
        if ($stmtKm0->num_rows == 0 && $stmtUsuario->num_rows == 0) {
            $sqlDelete = "DELETE FROM wp_posts WHERE ID = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $wp_post_id);
            $stmtDelete->execute();
            $stmtDelete->close();

            $productosEliminados++;
        }

        // Cerrar statements
        $stmtKm0->close();
        $stmtUsuario->close();
    }

    // Confirmar la transacción
    $conn->commit();

    echo "<div class='success'><h2>Limpieza completada</h2>";
    echo "<p>Se eliminaron $productosEliminados productos huérfanos de WordPress.</p></div>";
    echo '<a href="adminDashboard.php" class="btn">← Volver al panel</a>';

} catch (Exception $e) {
    $conn->rollback();
    echo "<div class='error'>Error durante la limpieza: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Cerrar la conexión
$conn->close();
?>

</body>
</html>
