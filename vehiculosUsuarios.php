<?php
// Incluir archivo de configuración de la base de datos
require_once './config/configBD.php'; 

// Crear la conexión con la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todos los vehículos de usuarios
$query = "SELECT * FROM coche_usuario";
$result = $conn->query($query);

// Mostrar error si la consulta falla
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .vehicle-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: white;
            text-align: center;
        }
        .vehicle-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .contact-info {
            margin-top: 10px;
        }
        .contact-btn {
            display: block;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        .contact-btn:hover {
            background-color: #0056b3;
        }
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 24px;
            text-align: center;
        }
        .whatsapp-btn:hover {
            background-color: #1ebe57;
        }
        .location-contact {
            text-align: center;
            margin-top: 20px;
        }
        header {
            background: url('./images/vehiculos2.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        footer {
            background: url('./images/vehiculos3.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <h1>Vehículos de Usuarios</h1>
    <p>Encuentra coches subidos por usuarios, disponibles para la compra</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #004A99;">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="vehiculosUsuarios.php" class="nav-link">Vehículos de Usuarios</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="vehicle-card">
                    <!-- Imagen del vehículo -->
                    <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['modelo']) ?>">
                    <h5><?= htmlspecialchars($row['marca']) ?> <?= htmlspecialchars($row['modelo']) ?></h5>
                    <p>Año: <?= htmlspecialchars($row['anio']) ?></p>
                    <p>Color: <?= htmlspecialchars($row['color']) ?></p>
                    <p>Tipo: <?= htmlspecialchars($row['tipo']) ?></p>
                    <p>Precio: €<?= number_format($row['presupuesto'], 0, ',', '.') ?></p>
                    <p>Kilómetros: <?= htmlspecialchars($row['kilometros']) ?></p>
                    <div class="contact-info">
                        <!-- Mostrar el número de contacto directamente desde la BD y crear el enlace de WhatsApp -->
                        <a href="https://wa.me/<?= htmlspecialchars($row['telefono']) ?>" class="contact-btn">
                            Contactar por WhatsApp: <?= htmlspecialchars($row['telefono']) ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<div class="location-contact">
    <p><strong>Visítanos:</strong> Calle Ejemplo, 123, Valencia, España</p>
</div>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>


