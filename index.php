<?php
session_start(); // Necesario para usar $_SESSION y controlar si el usuario ha iniciado sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario Manzano - Tu mejor opción</title>

    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        header {
            background: url('./images/concesionario1.jpg') no-repeat center/cover;
            padding: 5rem 2rem;
            text-align: center;
            background-position: center;
            background-size: cover;
            box-shadow: inset 0 0 0 1000px rgba(0,0,0,0.5);
            color: white;
        }

        header h1 {
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
        }

        header p {
            font-size: 1.25rem;
            color: #f0f0f0;
            margin-top: 1rem;
        }

        nav {
            background-color: #003366;
        }

        nav a {
            color: white;
            font-weight: 500;
            padding: 12px 20px;
            display: inline-block;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #00509E;
            border-radius: 5px;
        }

        .subtitulo {
            font-size: 1.75rem;
            color: #003366;
            margin-bottom: 1rem;
            display: block;
            text-transform: uppercase;
            font-weight: 600;
        }

        main {
            padding: 4rem 2rem;
        }

        .card-custom {
            border: none;
            transition: transform 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            width: 400px;
            height: 100%;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

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

        .whatsapp-btn:hover {
            background-color: #1ebe57;
        }

        footer {
            background: url('./images/vehiculos3.avif') no-repeat center/cover;
            text-align: center;
            padding: 3rem;
            font-weight: 600;
            color: darkblue;
        }

        footer a {
            text-decoration: none;
            font-weight: 500;
            color: darkblue;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .img-fluid {
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .nav-item .fas.fa-heart {
            color: red; /* Cambiar el color del corazón */
            font-size: 1.5rem; /* Ajustar el tamaño del ícono */
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido a Nuestro Concesionario</h1>
    <p>Encuentra el coche de tus sueños con las mejores condiciones</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario Manzano</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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
                    <li class="nav-item"><a href="favoritos.php" class="nav-link"><i class="fas fa-heart"></i></a></li>
                    <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li class="nav-item"><a href="adminDashboard.php" class="btn btn-warning nav-link">Panel Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main>
    <section id="nosotros" class="container my-5">
        <div class="card shadow">
            <img src="./images/concesionariosManzano.png" class="card-img-top" alt="Nosotros">
            <div class="card-body text-center">
                <h5 class="card-title">¿Quiénes Somos?</h5>
                <p class="card-text">Concesionario Manzano, tu mejor opción para comprar vehículos de calidad.</p>
                <a href="nosotros.php" class="btn btn-primary">Conócenos</a>
            </div>
        </div>
    </section>

    <section id="vehiculos" class="container my-5">
        <h2 class="subtitulo text-center">Algunos De Nuestros Vehículos</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom">
                    <img src="./images/coche1.avif" class="card-img-top" alt="Coche 1">
                    <div class="card-body">
                        <h5 class="card-title">Potencia y Elegancia</h5>
                        <p class="card-text">Domina la carretera con un diseño sofisticado y un rendimiento sin límites.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom">
                    <img src="./images/coche5.avif" class="card-img-top" alt="Coche 2">
                    <div class="card-body">
                        <h5 class="card-title">Innovación y Confort</h5>
                        <p class="card-text">Tecnología avanzada y comodidad excepcional.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom">
                    <img src="./images/coche3.avif" class="card-img-top" alt="Coche 3">
                    <div class="card-body">
                        <h5 class="card-title">Diseño Vanguardista</h5>
                        <p class="card-text">Estilo único y carácter inconfundible.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="vehiculos.php" class="btn btn-outline-primary btn-lg">Ver todos los vehículos <i class="fas fa-car ms-2"></i></a>
        </div>
    </section>

    <section id="financiacion" class="container my-5 text-center">
        <a href="financiacion.php" class="subtitulo">Opciones de Financiación</a>
        <p>Te ofrecemos planes de financiamiento a tu medida.</p>
        <img src="./images/hombreFinanciero.avif" alt="Financiación" class="img-fluid mt-3">
    </section>

    <section id="vehiculosUsuarios" class="container my-5 text-center">
        <a href="vehiculosUsuarios.php" class="subtitulo">Vehículos de Usuarios</a>
        <p>Explora opciones de otros usuarios a precios más accesibles.</p>
        <img src="./images/ventas.jpg" alt="VehiculosUsuarios" class="img-fluid mt-3">
    </section>

    <?php if (isset($_SESSION['usuario_id'])): ?>
    <section id="subeTuCoche" class="container my-5 text-center">
        <a href="subeTuCoche.php" class="subtitulo">Sube tu Coche</a>
        <p>¿Tienes un coche para vender? ¡Súbelo fácilmente!</p>
        <img src="./images/asesoramiento.avif" alt="Asesoramiento" class="img-fluid mt-3">
    </section>
    <?php endif; ?>

    <section id="contacto" class="container my-5 text-center">
        <a href="contacto.php" class="subtitulo">Contáctanos</a>
        <p>Visítanos o llámanos para recibir atención personalizada.</p>
        <img src="./images/instalaciones.avif" alt="Instalaciones" class="img-fluid mt-3">
    </section>
</main>

<a href="https://wa.me/608602302" class="whatsapp-btn" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<footer>
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
    <p>Teléfono de contacto +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php">Política de Privacidad</a> | <a href="politicaCookies.php">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


