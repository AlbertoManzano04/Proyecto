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
        /* Fuentes y fondo */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        header {
            background: url('./images/concesionario1.jpg') no-repeat center/cover;
            color: white;
            padding: 5rem 0;
            text-align: center;
            font-size: 2rem;
            background-position: center 68%;
            background-size: cover;
        }

        header h1 {
            font-size: 3rem;
            font-weight: 600;
            color: darkblue;
        }
        header p{
            color: white;
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
            color: #004A99;
            font-size: 2rem;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            display: block;
            margin-top: 40px;
        }

        .subtitulo:hover {
            text-decoration: underline;
        }

        main {
            padding: 4rem 2rem;
            text-align: center;
        }

        section {
            margin-bottom: 3rem;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        section:hover {
            box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Ajuste de imágenes para ser aún más pequeñas */
        section img {
            width: 50%;  /* Ajustamos el tamaño de las imágenes estáticas a 50% */
            height: auto;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            display: block;
        }

        /* Ajuste del carrusel de vehículos para hacerlo un poco más pequeño */
        #vehiculosCarrusel .carousel-item img {
            width: 100%;
            height: 450px;  /* Hacemos el carrusel más pequeño */
            object-fit: cover;
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 8px;
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
        .whatsapp-btn:hover { background-color: #1ebe57; }
        footer {
            background: url('./images/vehiculos3.avif') no-repeat center/cover;
            color: white;
            text-align: center;
            padding: 3rem;
            font-weight: 600;
            background-size: cover;
            color:darkblue;
        }

        footer a {
            text-decoration: none;
            font-weight: 500;
            color: darkblue;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .nav-item .fas.fa-heart {
            color: red;
            font-size: 1.5rem;
        }

        .img-fluid {
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
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
                    <li class="nav-item">
                        <a href="favoritos.php" class="nav-link">
                            <i class="fas fa-heart"></i>
                        </a>
                    </li>
                
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="registro.php" class="nav-link">Registro</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a href="adminDashboard.php" class="btn btn-warning nav-link">Panel Admin</a>
                    </li>
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
    <section id="vehiculos">
        <a href="vehiculos.php" class="subtitulo">Algunos De Nuestros Vehículos</a>
        <div id="vehiculosCarrusel" class="carousel slide mt-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/coche1.avif" class="d-block w-10" alt="Vehículo 1">
                    <div class="carousel-caption">
                        <h5>Potencia y Elegancia</h5>
                        <p>Domina la carretera con un diseño sofisticado y un rendimiento sin límites.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./images/coche2.avif" class="d-block w-100" alt="Vehículo 2">
                    <div class="carousel-caption">
                        <h5>Innovación y Confort</h5>
                        <p>La tecnología más avanzada combinada con la comodidad que mereces.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./images/coche3.avif" class="d-block w-100" alt="Vehículo 3">
                    <div class="carousel-caption">
                        <h5>Diseño Vanguardista</h5>
                        <p>Estilo único, líneas aerodinámicas y un carácter inconfundible en cada detalle.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./images/coche4.avif" class="d-block w-100" alt="Vehículo 4">
                    <div class="carousel-caption">
                        <h5>Seguridad y Confianza</h5>
                        <p>Disfruta de cada viaje con la máxima protección y estabilidad</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./images/coche5.avif" class="d-block w-100" alt="Vehículo 5">
                    <div class="carousel-caption">
                        <h5>Rendimiento Imparable</h5>
                        <p>Un motor potente y eficiente para llevarte más lejos.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#vehiculosCarrusel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#vehiculosCarrusel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <section id="financiacion">
        <a href="financiacion.php" class="subtitulo">Opciones de Financiación</a>
        <p>Te ofrecemos planes de financiamiento a tu medida.</p>
        <img src="./images/hombreFinanciero.avif" alt="Financiación" class="img-fluid">
    </section>

    <section id="vehiculosUsuarios">
        <a href="vehiculosUsuarios.php" class="subtitulo">Vehículos de Usuarios</a>
        <p>Explora opciones de otros usuarios a precios más accesibles.</p>
        <img src="./images/ventas.jpg" alt="VehiculosUsuarios" class="img-fluid">
    </section>

    <?php if (isset($_SESSION['usuario_id'])): ?>
    <section id="subeTuCoche">
        <a href="subeTuCoche.php" class="subtitulo">Sube tu Coche</a>
        <p>¿Tienes un coche para vender? ¡Súbelo fácilmente!</p>
        <img src="./images/asesoramiento.avif" alt="Asesoramiento" class="img-fluid">
    </section>
    <?php endif; ?>

    <section id="contacto">
        <a href="contacto.php" class="subtitulo">Contáctanos</a>
        <p>Visítanos o llámanos para recibir atención personalizada.</p>
        <img src="./images/instalaciones.avif" alt="Instalaciones" class="img-fluid">
    </section>
</main>
<a href="https://wa.me/608602302" class="whatsapp-btn" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>
<footer>
    <p>&copy; 2025 Concesionario Manzano. Todos los derechos reservados.</p>
    <p>Telefono de contacto +34 608 60 23 02</p>
    <p><a href="politicaPrivacidad.php">Política de Privacidad</a> | <a href="politicaCookies.php">Política de Cookies</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

