<?php
session_start();
require_once './config/configBD.php'; 

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "SELECT * FROM coche_usuario";
$result = $conn->query($query);
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

function esFavorito($vehiculo_id, $usuario_id, $conn) {
    $stmt = $conn->prepare("SELECT 1 FROM usuarios_favoritos WHERE usuario_id = ? AND vehiculo_id = ?");
    $stmt->bind_param("ii", $usuario_id, $vehiculo_id);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vehículos de Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; }
        h1, h2 { color: #003366; }
        .vehicle-card {
            border: none;
            padding: 20px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }
        .vehicle-card:hover { transform: translateY(-5px); }
        .vehicle-card img {
            max-width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 12px;
        }
        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
        }
        .contact-btn {
            display: block;
            background-color: #25D366;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        .contact-btn:hover { background-color: #1ebe57; }
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 28px;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .whatsapp-btn:hover { background-color: #1ebe57; }
        header {
            background: url('./images/vehiculoUsuario.jpg') no-repeat center/cover;
            color: white;
            padding: 3rem 0;
            text-align: center;
            background-position: center 27%;
        }
        footer {
            background: url('./images/vehiculoUsuario2.avif') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        nav { background-color: #004A99; }
        nav a {
            color: white;
            font-weight: bold;
            padding: 15px 20px;
            text-decoration: none;
            display: inline-block;
        }
        nav a:hover {
            background-color: #0066CC;
            border-radius: 5px;
        }
        .nav-item .fas.fa-heart {
            color: red;
            font-size: 1.5rem;
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
            <div class="col-md-4 mb-4">
                <div class="vehicle-card shadow-sm position-relative">
                    <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['modelo']) ?>">
                    <h5 class="mt-3"><?= htmlspecialchars($row['marca']) ?> <?= htmlspecialchars($row['modelo']) ?></h5>
                    <p><strong>Año:</strong> <?= htmlspecialchars($row['anio']) ?></p>
                    <p><strong>Color:</strong> <?= htmlspecialchars($row['color']) ?></p>
                    <p><strong>Tipo:</strong> <?= htmlspecialchars($row['tipo']) ?></p>
                    <p><strong>Precio:</strong> €<?= number_format($row['presupuesto'], 0, ',', '.') ?></p>
                    <p><strong>Kilómetros:</strong> <?= htmlspecialchars($row['kilometros']) ?> km</p>

                    <?php if ($usuario_id): ?>
                        <form action="agregar_favorito.php" method="POST" class="mt-2">
                            <input type="hidden" name="vehiculo_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn <?= esFavorito($row['id'], $usuario_id, $conn) ? 'btn-danger' : 'btn-outline-secondary' ?> btn-sm w-100">
                                <i class="fas fa-heart me-1"></i>
                                <?= esFavorito($row['id'], $usuario_id, $conn) ? 'Quitar de Favoritos' : 'Agregar a Favoritos' ?>
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="https://wa.me/<?= htmlspecialchars($row['telefono']) ?>" class="contact-btn" target="_blank">
                        <i class="fab fa-whatsapp me-1"></i> Contactar por WhatsApp
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<div class="location-contact text-center mb-4">
    <p><strong>Visítanos:</strong> Calle Ejemplo, 123, Valencia, España</p>
</div>

<a href="https://wa.me/608602302" class="whatsapp-btn" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    <p><a href="politicaPrivacidad.php" style="color: white;">Política de Privacidad</a> | <a href="politicaCookies.php" style="color: white;">Política de Cookies</a></p>
</footer>º
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



