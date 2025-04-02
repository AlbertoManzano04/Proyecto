<?php
// Incluir configuración de base de datos
require_once __DIR__ . '/config/configBD.php';

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $tipo = $_POST['tipo'];
    $presupuesto = $_POST['presupuesto'];
    $kilometros = $_POST['kilometros'];
    $telefono = $_POST['contacto']; // Añadido para recoger el teléfono

    // Manejo de la imagen
    $directorio = "uploads/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $archivoImagen = $directorio . basename($_FILES["imagen"]["name"]);
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivoImagen);

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO coche_usuario (marca, modelo, anio, color, tipo, presupuesto, kilometros, imagen, telefono) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssiss", $marca, $modelo, $anio, $color, $tipo, $presupuesto, $kilometros, $archivoImagen, $telefono);

    if ($stmt->execute()) {
        echo "<script>alert('Coche subido con éxito'); window.location.href='vehiculosUsuarios.php';</script>";
    } else {
        echo "<script>alert('Error al subir el coche');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Coche - Vender tu Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: lightgray;
        }
        header, footer {
            background: url('./images/vehiculos2.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container label {
            font-weight: bold;
        }
        nav {
            background-color: #004A99;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 15px 20px;
            display: inline-block;
        }
        nav a:hover {
            background-color: #0066CC;
            border-radius: 5px;
        }

        .highlight-text {
            font-size: 1.2rem;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .sube-coche-description {
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<header>
    <h1>Vende tu Vehículo</h1>
    <p>Comparte las características de tu coche y sube imágenes para venderlo</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="vehiculosUsuarios.php" class="nav-link">Vehículos de Usuarios</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                <!-- Menú desplegable -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Concesionarios Manzano
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="nosotros.php">Nosotros</a></li>
                        <li><a class="dropdown-item" href="trabajaConNosotros.php">Trabaja con Nosotros</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    <div class="sube-coche-description">
        <h3 class="highlight-text">¡Vende tu coche de manera rápida y fácil!</h3>
        <p>¿Estás buscando vender tu vehículo? ¡Estás en el lugar indicado! Completa este sencillo formulario, sube las fotos de tu coche y nosotros nos encargaremos del resto. Te garantizamos un proceso rápido, seguro y con una excelente valoración. ¡Aprovecha esta oportunidad para vender tu coche de forma sencilla y sin complicaciones!</p>
    </div>

    <div class="form-container">
        <h3 class="text-center">Formulario para Vender tu Vehículo</h3>
        <form method="POST" action="subeTuCoche.php" enctype="multipart/form-data" class="row">
            <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" id="marca" name="marca" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" id="modelo" name="modelo" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="anio" class="form-label">Año</label>
                <input type="number" id="anio" name="anio" class="form-control" required min="1990" max="2025">
            </div>

            <div class="col-md-6 mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="text" id="color" name="color" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="">Seleccione el tipo</option>
                    <option value="SUV">SUV</option>
                    <option value="Sedán">Sedán</option>
                    <option value="Deportivo">Deportivo</option>
                    <option value="Camioneta">Camioneta</option>
                    <option value="Hatchback">Hatchback</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="presupuesto" class="form-label">Presupuesto (€)</label>
                <input type="number" id="presupuesto" name="presupuesto" class="form-control" required min="1000">
            </div>

            <div class="col-md-6 mb-3">
                <label for="kilometros" class="form-label">Kilómetros recorridos</label>
                <input type="number" id="kilometros" name="kilometros" class="form-control" required min="0">
            </div>

            <div class="col-md-12 mb-3">
                <label for="imagen" class="form-label">Sube Imagen del Coche</label>
                <input type="file" id="imagen" name="imagen" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="contacto" class="form-label">Número de Contacto</label>
                <input type="tel" id="contacto" name="contacto" class="form-control" required pattern="[0-9]{9}" placeholder="Ej. 612345678">
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Subir Coche</button>
            </div>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

