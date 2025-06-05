<?php
session_start(); // Iniciar la sesión
// Incluir archivo de configuración de la base de datos
require_once './config/configBD.php';

// Crear la conexión con la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    die("No estás logueado. Debes iniciar sesión para agregar favoritos.");
}

$usuario_id = $_SESSION['usuario_id'];
$vehiculo_id = isset($_POST['vehiculo_id']) ? (int)$_POST['vehiculo_id'] : null;

if (!$vehiculo_id) {
    die("No se ha especificado un vehículo.");
}

// Verificar si el vehículo ya está en favoritos
$query = "SELECT * FROM usuarios_favoritos WHERE usuario_id = ? AND vehiculo_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $usuario_id, $vehiculo_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El vehículo ya está en los favoritos, por lo que lo eliminamos
    $query_delete = "DELETE FROM usuarios_favoritos WHERE usuario_id = ? AND vehiculo_id = ?";
    $stmt_delete = $conn->prepare($query_delete);
    $stmt_delete->bind_param("ii", $usuario_id, $vehiculo_id);
    $stmt_delete->execute();

    echo "Vehículo eliminado de favoritos.";
} else {
    // El vehículo no está en los favoritos, por lo que lo agregamos
    $query_insert = "INSERT INTO usuarios_favoritos (usuario_id, vehiculo_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($query_insert);
    $stmt_insert->bind_param("ii", $usuario_id, $vehiculo_id);
    $stmt_insert->execute();

    echo "Vehículo agregado a favoritos.";
}

// Obtener la URL de la página anterior (de donde vino el usuario)
$referer = $_SERVER['HTTP_REFERER'];

// Si viene de 'vehiculosUsuarios.php', redirigir a esa página
if (strpos($referer, 'vehiculosUsuarios.php') !== false) {
    header("Location: vehiculosUsuarios.php");
} else {
    // Si viene de cualquier otra página (por ejemplo, 'vehiculos.php'), redirigir a 'vehiculos.php'
    header("Location: vehiculos.php");
}

exit();
?>
