<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Concesionarios Manzano</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: lightgray;
        }
        h2{
            text-align: center;
        }
        header {
            background: url('./images/concesionario1.jpg') no-repeat center/cover;
            color: white;
            padding: 3rem 0;
            text-align: center;
            font-size: 1.5rem;
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

        main {
            padding: 3rem;
            text-align: center;
        }
        section {
            margin-bottom: 3rem;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .imagenes-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .imagenes-container img,
        .imagenesValores img,
        main img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Estilos del carrusel */
        .carousel-item img {
            width: 400px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Concesionarios Manzano</h1>
    <p>Conoce más sobre nosotros</p>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Concesionarios Manzano</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="vehiculos.php" class="nav-link">Vehículos km0</a></li>
                <li class="nav-item"><a href="vehiculosUsuarios.php" class="nav-link">Vehículos de Usuarios</a></li>
                <li class="nav-item"><a href="financiacion.php" class="nav-link">Financiación</a></li>
                <li class="nav-item"><a href="subeTuCoche.php" class="nav-link">Sube tu coche</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                <li class="nav-item"><a href="nosotros.php" class="nav-link">Nosotros</a></li>
            </ul>
        </div>
    </div>
</nav>

<section>
    <h2>Nuestras Instalaciones</h2>
    <div class="imagenes-container">
        <div><img src="./images/instalacion1.jpeg" alt="Instalación 1"></div>
        <div><img src="./images/instalacion2.jpeg" alt="Instalación 2"></div>
        <div><img src="./images/instalacion3.jpeg" alt="Instalación 3"></div>
        <div><img src="./images/instalacion4.jpeg" alt="Instalación 4"></div>
    </div>
</section>

<main>
    <section>
        <h2>¿Quiénes Somos?</h2>
        <p>En <strong>Concesionarios Manzano</strong> nos dedicamos a ofrecer una amplia variedad de vehículos nuevos y de segunda mano con la mejor calidad y al mejor precio. Contamos con más de 20 años de experiencia en el sector, lo que nos ha permitido consolidarnos como una de las opciones más confiables y preferidas por nuestros clientes.</p>
        <img src="./images/quienesSomos.jpg" style="object-position: center 10%;" alt="">
        <h3>Nuestra Misión</h3>
        <p>Brindar a nuestros clientes vehículos que se adapten a sus necesidades y presupuesto, ofreciendo un servicio personalizado y un trato cercano. Nos importa tu satisfacción, por eso nos aseguramos de que cada vehículo que ofrecemos esté en las mejores condiciones.</p>
        <img src="./images/IA.png" style="object-position: center 35%;" alt="">
        <h3>Nuestros Valores</h3>
        <ul>
            <li><strong>Compromiso:</strong> Estamos comprometidos con cada cliente, ofreciendo un servicio excepcional y vehículos de calidad.</li>
            <li><strong>Transparencia:</strong> Actuamos con honestidad en todo momento, desde el momento en que te asesores hasta la entrega del vehículo.</li>
            <li><strong>Innovación:</strong> Siempre buscamos nuevas formas de mejorar la experiencia de compra y postventa de nuestros clientes.</li>
            <li><strong>Confianza:</strong> Queremos que nuestros clientes confíen en nosotros como su opción preferida cuando se trata de comprar un coche.</li>
        </ul>
            <img src="./images/compromiso.jpg" alt="">
        <h3>Nuestro Equipo</h3>
        <p>Contamos con un equipo altamente cualificado y apasionado por el mundo del motor. Desde nuestros asesores hasta nuestro equipo de taller, trabajamos con dedicación para ofrecerte el mejor servicio.</p>
        <section>
        <h2>Conoce a nuestro equipo</h2>
        <<div id="carouselEquipo" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./images/equipo1.jpg" class="d-block mx-auto" alt="Miembro del equipo 1">
        </div>
        <div class="carousel-item">
            <img src="./images/equipo2.jpg" class="d-block mx-auto" alt="Miembro del equipo 2">
        </div>
        <div class="carousel-item">
            <img src="./images/equipo3.jpg" class="d-block mx-auto" alt="Miembro del equipo 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselEquipo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselEquipo" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>
    </section>
        <h3>Visítanos</h3>
        <p>Nos encantaría que nos visitaras. Nuestro concesionario está ubicado en el centro de la ciudad, donde podrás conocer a nuestro equipo, ver nuestra amplia oferta de vehículos y recibir asesoramiento personalizado.</p>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
