<?php
session_start();
require_once './config/configBD.php';

if (!isset($_SESSION['usuario_id']) || !isset($_POST['vehiculo_id'])) {
    echo json_encode(['status' => 'error']);
    exit;
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$usuario_id = $_SESSION['usuario_id'];
$vehiculo_id = $_POST['vehiculo_id'];

$stmt = $conn->prepare("SELECT id FROM usuarios_favoritos WHERE usuario_id = ? AND vehiculo_id = ?");
$stmt->bind_param("ii", $usuario_id, $vehiculo_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $conn->query("DELETE FROM usuarios_favoritos WHERE usuario_id = $usuario_id AND vehiculo_id = $vehiculo_id");
    echo json_encode(['status' => 'removed']);
} else {
    $conn->query("INSERT INTO usuarios_favoritos (usuario_id, vehiculo_id) VALUES ($usuario_id, $vehiculo_id)");
    echo json_encode(['status' => 'added']);
}
?>
