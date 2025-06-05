<?php
require_once './config/configBD.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM notas WHERE id = $id");
}
header("Location: adminDashboard.php");
?>