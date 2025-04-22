<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de vehículo no proporcionado.");
}

$id = $_GET['id'];
$vehiculo = null;
$tabla = null;

$stmt = $conn->prepare("SELECT * FROM coche_usuario WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $vehiculo = $result->fetch_assoc();
    $tabla = 'coche_usuario';
} else {
    $stmt = $conn->prepare("SELECT * FROM vehiculos_km0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $vehiculo = $result->fetch_assoc();
        $tabla = 'vehiculos_km0';
    } else {
        die("Vehículo no encontrado.");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
        }
        header {
            background: linear-gradient(to right, #004a99, #007bff);
            color: white;
            padding: 4rem 1rem;
            text-align: center;
            border-bottom: 5px solid #004a99;
        }
        
        header h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        nav {
            background-color: #003366;
        }

        nav a.nav-link, nav .navbar-brand {
            color: white;
            font-weight: 500;
        }

        nav a:hover {
            color: #ffc107;
        }

        .form-section {
            background-color: #fff;
            padding: 3rem;
            margin: 3rem auto;
            max-width: 800px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            display: block;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 0.8rem;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.5);
        }

        .form-section img {
            border-radius: 12px;
            max-height: 150px;
            margin-top: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 600;
            padding: 0.7rem 1.4rem;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            margin-left: 10px;
            border-radius: 10px;
            padding: 0.7rem 1.4rem;
        }

        .status-message {
            margin: 2rem auto;
            width: 90%;
            max-width: 600px;
        }
    </style>
</head>
<body>

<header>
    <h1><i class="bi bi-pencil-square"></i> Editar Vehículo</h1>
</header>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="adminDashboard.php">
            <i class="bi bi-house-door-fill me-2"></i> Inicio
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container">
    <div class="form-section">
        <form action="guardarEdicionCoche.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $vehiculo['id'] ?>">
            <input type="hidden" name="tabla" value="<?= $tabla ?>">

            <div class="row mb-3">
                <div class="col">
                    <label>Marca</label>
                    <input type="text" name="marca" class="form-control" value="<?= htmlspecialchars($vehiculo['marca']) ?>" required>
                </div>
                <div class="col">
                    <label>Modelo</label>
                    <input type="text" name="modelo" class="form-control" value="<?= htmlspecialchars($vehiculo['modelo']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="<?= htmlspecialchars($vehiculo['anio']) ?>" required>
                </div>
                <div class="col">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control" value="<?= htmlspecialchars($vehiculo['color']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Tipo de vehículo</label>
                    <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($vehiculo['tipo']) ?>">
                </div>
                <div class="col">
                    <label>Precio (€)</label>
                    <input type="number" name="presupuesto" class="form-control" value="<?= htmlspecialchars($vehiculo['presupuesto']) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Kilómetros</label>
                <input type="number" name="kilometros" class="form-control" value="<?= htmlspecialchars($vehiculo['kilometros']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Imagen (opcional)</label>
                <input type="file" name="imagen" class="form-control">
                <?php if (!empty($vehiculo['imagen'])): ?>
                    <p class="mt-2">Imagen actual:</p>
                    <img src="<?= htmlspecialchars($vehiculo['imagen']) ?>" alt="Imagen del vehículo">
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save2"></i> Guardar Cambios</button>
                <a href="adminDashboard.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





