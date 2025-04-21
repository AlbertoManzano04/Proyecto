<?php
session_start();
require_once './config/configBD.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$id = $_POST['id'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$anio = $_POST['anio']; 
$color = $_POST['color'];
$tipoVehiculo = $_POST['tipo'];
$presupuesto = $_POST['presupuesto'];
$kilometros = $_POST['kilometros'];


// Subida de imagen (si hay)
$imagen = null;
if (!empty($_FILES['imagen']['name'])) {
    $target_dir = "./";
    $imagen = $target_dir . basename($_FILES["imagen"]["name"]);
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen);
}

// Decidir la tabla según los kilómetros
$tabla = ($kilometros == 0) ? "vehiculos_km0" : "coche_usuario";

// Preparar y ejecutar la consulta
    if ($tabla === "vehiculos_km0") {
        $stmt = $conn->prepare("UPDATE vehiculos_km0 SET marca=?, modelo=?, anio=?, color=?, tipo=?, presupuesto=?, kilometros=?, imagen=? WHERE id=?");
        $stmt->bind_param("ssisssdsi", $marca, $modelo, $anio, $color, $tipoVehiculo, $presupuesto, $kilometros, $imagen, $id);
    } else {
        $stmt = $conn->prepare("UPDATE coche_usuario SET marca=?, modelo=?, anio=?, color=?, tipo=?, presupuesto=?, kilometros=?, imagen=? WHERE id=?");
        $stmt->bind_param("ssisssdsi", $marca, $modelo, $anio, $color, $tipoVehiculo, $presupuesto, $kilometros, $imagen, $id);
    }


$stmt->execute();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        header {
            background: url('./images/administracion.avif') no-repeat center/cover;
            color: darkblue;
            padding: 3rem 0;
            text-align: center;
            font-size: 1.5rem;
            background-position: center 65%;
        }
        .form-section {
            background: white;
            padding: 2rem;
            margin: 2rem 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        nav {
            background-color: #004A99;
        }

        nav a {
            color: white;
            font-weight: bold;
            padding: 15px 20px;
            display: inline-block;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #0066CC;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <h1>Editar Vehículo</h1>
</header>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="adminDashboard.php">Panel de Administración</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="adminDashboard.php">Inicio</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<form action="procesarEdicionCoche.php" method="post" enctype="multipart/form-data">
    <!-- Campo oculto para el tipo de vehículo, si lo necesitas -->
    <input type="hidden" name="tipo" value="<?= $tipo ?>">

    <!-- Resto de los campos del formulario -->
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
            <label>Tipo de vehículo (ej: SUV, berlina, etc)</label>
            <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($vehiculo['tipo']) ?>">
        </div>
        <div class="row mb-3">
    <div class="col">
        <label>Precio</label>
        <input type="number" name="presupuesto" class="form-control" value="<?= htmlspecialchars($vehiculo['presupuesto']) ?>" required>
    </div>
    <div class="col">
        <label>Kilómetros</label>
        <input type="number" name="kilometros" class="form-control" value="<?= htmlspecialchars($vehiculo['kilometros']) ?>" required>
    </div>
</div>
    <div class="mb-3">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control">
        <p>Imagen actual: <img src="./<?= htmlspecialchars($vehiculo['imagen']) ?>" width="100"></p>
    </div>
    <button type="submit" name="editar" value="editar" class="btn btn-primary">Guardar Cambios</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
