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
            background: url('concesionario1.jpg') no-repeat center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        nav {
            background-color: #E6E6E6;
            padding: 1rem;
            text-align: center;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #004A99;
            font-weight: bold;
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
            color: darkblue;
        }
        .carousel-container {
        max-width: 400px; 
        margin: 0 auto; 
    }
    .carousel-item img {
        max-height: 250px; 
        object-fit: cover; 
    }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido a Nuestro Concesionario</h1>
    <p>Encuentra el coche de tus sueños con las mejores condiciones</p>
</header>

<nav>
    <a href="vehiculos.php">Vehículos</a>
    <a href="#financiacion">Financiación</a>
    <a href="#servicios">Servicios</a>
    <a href="#contacto">Contacto</a>
</nav>

<main>
    <section id="vehiculos">
        <h2>Algunos De Nuestros Vehículos</h2>

        <div class="carousel-container">
    <div id="vehiculosCarrusel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="coche1.avif" class="d-block w-100" alt="Vehículo 1">
            </div>
            <div class="carousel-item">
                <img src="coche2.avif" class="d-block w-100" alt="Vehículo 2">
            </div>
            <div class="carousel-item">
                <img src="coche3.avif" class="d-block w-100" alt="Vehículo 3">
            </div>
            <div class="carousel-item">
                <img src="coche4.avif" class="d-block w-100" alt="Vehículo 4">
            </div>
            <div class="carousel-item">
                <img src="coche5.avif" class="d-block w-100" alt="Vehículo 5">
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
        <img src="hombreFinanciero.avif" alt="Financias">
    </section>

    <section id="servicios">
        <h2>Servicios Exclusivos</h2>
        <p>Desde asesoramiento hasta mantenimiento, estamos para ayudarte.</p>
        <img src="asesoramiento.avif" alt="asesoramineto">
    </section>

    <section id="contacto">
        <h2>Contáctanos</h2>
        <p>Visítanos o llámanos para recibir atención personalizada.</p>
        <img src="instalaciones.avif" alt="instalaciones">
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
