<?php
session_start(); // Inicia la sesión

// Verifica si la sesión existe y si el rol es 'admin'
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    echo "No tienes permisos para realizar esta acción.";
    exit();  // Termina la ejecución si el usuario no es admin
}

require_once './config/configBD.php';

if (isset($_GET['id'])) {
    $usuarioId = (int)$_GET['id'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Borrar primero los coches favoritos
    $stmt = $conn->prepare("DELETE FROM usuarios_favoritos WHERE usuario_id = ?");
    if (!$stmt) {
        die("Error en la consulta: " . $conn->error); // Si prepare falla, muestra el error
    }
    $stmt->bind_param("i", $usuarioId);
    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta de favoritos: " . $stmt->error);
    }

    // Finalmente borrar usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    if (!$stmt) {
        die("Error en la consulta: " . $conn->error); // Si prepare falla, muestra el error
    }
    $stmt->bind_param("i", $usuarioId);
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: adminDashboard.php?message=Usuario eliminado con éxito");
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de usuario no válido.";
}
?>

