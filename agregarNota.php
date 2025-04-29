<?php
require_once './config/configBD.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenido = trim($_POST['contenido']);
    if (!empty($contenido)) {
        $stmt = $conn->prepare("INSERT INTO notas (contenido) VALUES (?)");
        $stmt->bind_param("s", $contenido);
        $stmt->execute();
    }
}
header("Location: adminDashboard.php");
?>