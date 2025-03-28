<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - Tu mejor opción</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: lightgray;
        }
        header {
            background: url('./images/concesionario1.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
       /* Estilos para el nav */
       nav {
            background-color: #004A99; /* Fondo azul */
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
        /* Estilos para hacer el nav responsivo */
        @media (max-width: 768px) {
            nav {
                text-align: center;
            }
            nav a {
                display: block;
                margin: 5px 0;
            }
        }
        main {
            padding: 2rem;
        }
        section {
            margin-bottom: 2rem;
            text-align: center;
        }
        footer {
            background-color: #004A99;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }
        h1 {
            color: darkblue;
        }
        p {
            color: white;
        }
        .carousel-container {
            max-width: 100%; 
            margin: 0 auto;
        }
        .carousel-item img {
            width: 100%;
            height: 600px; 
            object-fit: cover;
        }
        .carousel-caption {
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 1.5rem;
            font-weight: bold;
            left: 20%;
            top: 10%;
        }
    footer{
        background: url('./images/vehiculos3.avif') no-repeat center/cover;
        color: white;
        padding: 2rem 0;
        text-align: center;
    }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido a Nuestro Concesionario</h1>
    <p>Encuentra el coche de tus sueños con las mejores condiciones</p>
</header>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionario</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<main>
<section id="vehiculos">
        <h2>Algunos De Nuestros Vehículos</h2>

        <div class="carousel-container">
            <div id="vehiculosCarrusel" class="carousel slide mt-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./images/coche1.avif" class="d-block w-100" alt="Vehículo 1">
                        <div class="carousel-caption">
                            <h2>Potencia y Elegancia</h5>
                            <p>Descubre el rendimiento superior de nuestro modelo estrella.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./images/coche2.avif" class="d-block w-100" alt="Vehículo 2">
                        <div class="carousel-caption">
                            <h2>Innovación y Confort</h5>
                            <p>Viaja con la última tecnología y comodidad garantizada.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./images/coche6.avif" class="d-block w-100" alt="Vehículo 3">
                        <div class="carousel-caption">
                            <h2>Diseño Vanguardista</h5>
                            <p>Un modelo que destaca en la carretera.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./images/coche4.avif" class="d-block w-100" alt="Vehículo 4">
                        <div class="carousel-caption">
                            <h2>Seguridad y Confianza</h5>
                            <p>Viaja con la tranquilidad de nuestros sistemas avanzados.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./images/coche5.avif" class="d-block w-100" alt="Vehículo 5">
                        <div class="carousel-caption">
                            <h2>El Futuro es Ahora</h5>
                            <p>Experimenta la conducción del mañana, hoy.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#vehiculosCarrusel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#vehiculosCarrusel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <section id="financiacion">
        <h2>Opciones de Financiación</h2>
        <p>Te ofrecemos planes de financiamiento a tu medida.</p>
        <img src="./images/hombreFinanciero.avif" alt="Financias">
    </section>

    <section id="servicios">
        <h2>Servicios Exclusivos</h2>
        <p>Desde asesoramiento hasta mantenimiento, estamos para ayudarte.</p>
        <img src="./images/asesoramiento.avif" alt="asesoramineto">
    </section>

    <section id="contacto">
        <h2>Contáctanos</h2>
        <p>Visítanos o llámanos para recibir atención personalizada.</p>
        <img src="./images/instalaciones.avif" alt="instalaciones">
    </section>
</main>

<footer>
    <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    <p>Politica de Privacidad</p> <p>Politica de cookies</p>
</footer>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
