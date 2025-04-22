<?php
session_start();
require_once "./config/configBD.php"; // Incluir tu archivo de configuración de base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Si no está logueado, redirigir a login
    exit();
}

$usuario_id = $_SESSION['usuario_id']; // Obtener el ID del usuario logueado

// Conexión a la base de datos
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar si la conexión fue exitosa
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Obtener los coches favoritos del usuario desde la tabla usuarios_favoritos
$sql = "SELECT v.id, v.marca, v.modelo, v.presupuesto AS precio, v.color, v.tipo, v.imagen 
        FROM vehiculos_km0 v
        JOIN usuarios_favoritos f ON v.id = f.vehiculo_id
        WHERE f.usuario_id = ?
        UNION
        SELECT v.id, v.marca, v.modelo, v.presupuesto AS precio, v.color, v.tipo, v.imagen 
        FROM coche_usuario v
        JOIN usuarios_favoritos f ON v.id = f.vehiculo_id
        WHERE f.usuario_id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $usuario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Comprobar si el usuario tiene coches favoritos
if ($result->num_rows > 0) {
    $favoritos = $result->fetch_all(MYSQLI_ASSOC); // Obtener los coches favoritos
} else {
    $favoritos = []; // Si no tiene favoritos
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos - Concesionario Manzano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: lightgray;
        }
        h1,p{
            color: darkblue;
        }
        .vehiculo {
            background-color: white;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .vehiculo img {
            width: 100%;
            height: 300px;
            border-radius: 10px;
        }
        .vehiculo h5 {
            margin-top: 10px;
            color: darkblue;
        }
        .vehiculo p {
            color: #666;
        }
        header {
            background: url('./images/cocheFav.png') no-repeat center/cover;
            color: white;
            padding: 3rem 0;
            text-align: center;
            font-size: 1.5rem;
            background-position: center 25%;
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

        footer {
            background: url('./images/footerFav.jpg') no-repeat center/cover;
            color: white;
            text-align: center;
            padding: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header class="text-center py-5">
    <h1>Mis Coches Favoritos</h1>
    <p>Estos son los coches que has marcado como favoritos</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Menú desplegable funcional gracias a Bootstrap -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
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
                    <li class="nav-item">
                        <a href="favoritos.php" class="nav-link">
                            <i class="fas fa-heart"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>

                <!-- Si el usuario está logueado, no mostrar Login/Registro -->
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <!-- Aquí puedes colocar un enlace de Cerrar sesión o similar -->
                    <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
                <?php endif; ?>

                <!-- Mostrar el enlace al Panel Admin solo si el usuario es admin -->
                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a href="adminDashboard.php" class="btn btn-warning nav-link">Panel Admin</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    <?php if (count($favoritos) > 0): ?>
        <div class="row">
            <?php foreach ($favoritos as $vehiculo): ?>
                <div class="col-md-4">
                    <div class="vehiculo">
                        <img src="<?php echo $vehiculo['imagen']; ?>" alt="<?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>" class="img-fluid">
                        <h5><?php echo $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?></h5>
                        <p><strong>Color:</strong> <?php echo $vehiculo['color']; ?></p>
                        <p><strong>Tipo:</strong> <?php echo $vehiculo['tipo']; ?></p>
                        <p><strong>Precio:</strong> $<?php echo number_format($vehiculo['precio'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No tienes coches favoritos aún. ¡Explora nuestros vehículos y añade algunos a tus favoritos!</p>
    <?php endif; ?>
</main>

<footer class="text-center py-4">
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


