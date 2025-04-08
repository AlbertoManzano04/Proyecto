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

// Consulta para obtener todos los vehículos de usuarios
$query = "SELECT * FROM coche_usuario";
$result = $conn->query($query);

// Mostrar error si la consulta falla
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Verificar si el usuario está logueado
$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos de Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-item .fas.fa-heart {
            color: red; /* Cambiar el color del corazón */
            font-size: 1.5rem; /* Ajustar el tamaño del ícono */
        }
        body {
            background-color: lightgray;
        }
        h1, h2 {
            color: darkblue;
        }
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
            height: 300px;
            width: auto;
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
            background: url('./images/vehiculoUsuario.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
            background-position: center 27%;
        }
        footer {
            background: url('./images/vehiculoUsuario2.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
            background-position: center 60%;
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
    <h1>Vehículos de Usuarios</h1>
    <p>Encuentra coches subidos por usuarios, disponibles para la compra</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Concesionarios Manzano
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="nosotros.php">Nosotros</a></li>
                        <li><a class="dropdown-item" href="trabajaConNosotros.php">Trabaja con Nosotros</a></li>
                        
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <li><a class="dropdown-item" href="comparator.php">Compara los Coches</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="vehiculosUsuarios.php" class="nav-link">Vehículos de Usuarios</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                    <!-- Icono de corazón que lleva a favoritos.php, solo si el usuario está logueado -->
                    <li class="nav-item">
                        <a href="favoritos.php" class="nav-link">
                            <i class="fas fa-heart"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>

                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
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
                        <!-- Botón de Favorito encima del botón de WhatsApp -->
                        <?php if ($usuario_id): ?>
                            <?php
                                // Verificar si este vehículo está en los favoritos del usuario
                                $check_fav_query = "SELECT * FROM usuarios_favoritos WHERE usuario_id = ? AND vehiculo_id = ?";
                                $stmt = $conn->prepare($check_fav_query);
                                $stmt->bind_param("ii", $usuario_id, $row['id']);
                                $stmt->execute();
                                $fav_result = $stmt->get_result();
                            ?>
                            <form action="agregar_favorito.php" method="POST">
                                <input type="hidden" name="vehiculo_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn <?= $fav_result->num_rows > 0 ? 'btn-danger' : 'btn-outline-primary' ?>">
                                    <?= $fav_result->num_rows > 0 ? 'Eliminar de Favoritos' : 'Agregar a Favoritos' ?>
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Botón de contacto por WhatsApp -->
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
</html
